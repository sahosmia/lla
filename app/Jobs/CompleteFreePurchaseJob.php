<?php

namespace App\Jobs;

use App\Models\Order;
use App\Models\SlotBooking;
use App\Models\User;
use App\Services\BookingService;
use App\Services\OrderService;
use Carbon\Carbon;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Nwidart\Modules\Facades\Module;

class CompleteFreePurchaseJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected Order $order;
    protected BookingService $bookingService;
    protected OrderService $orderService;

    /**
     * Create a new job instance.
     */
    public function __construct(Order $order)
    {
        $this->order            = $order;
    }

    /**
     * Execute the job.
     */
    public function handle(BookingService $bookingService, OrderService $orderService): void
    {
        try {
            $this->bookingService   = $bookingService;
            $this->orderService     = $orderService;
            
            $tutorBookings = $tutorFunds = [];

            DB::beginTransaction();
            if (!empty($this->order->items)) {
                foreach($this->order->items as $item) {
                    $tutorBookings[$item->orderable?->bookee?->id][] = $item;
                }

                //Tutor bookings
                if (!empty($tutorBookings)) {
                    $tutorForEmail = null;
                    foreach ($tutorBookings as $tutorId => $bookings) {
                        $emailData = [];
                        $emailData['emailFor']  = 'tutor';
                        foreach($bookings as $booking) {
                            if($booking->orderable instanceof SlotBooking) {
                                $emailData['tutorName'] = $booking->orderable?->tutor?->full_name;
                                $tutorForEmail = $booking->orderable?->bookee;
                                $emailData['bookings'][]=[
                                    'studentName' => $booking->orderable?->student?->full_name,
                                    'studentImg'  => $booking->orderable?->student?->image,
                                    'subjectName' => $booking->options['subject_group'] . ' <br /> ' . $booking->options['subject'],
                                    'sessionTime' => $this->bookingService->getBookingTime($booking->orderable, 'bookee', true)
                                ];
                            } elseif(\Nwidart\Modules\Facades\Module::has('courses') && \Nwidart\Modules\Facades\Module::isEnabled('courses') && $booking->orderable instanceof \Modules\Courses\Models\Course) {
                                $emailData['tutorName'] = $booking->orderable->instructor?->profile?->full_name;
                                $tutorForEmail = $booking->orderable->instructor;
                                $emailData['courses'][]=[
                                    'studentName' => $this->order?->userProfile?->full_name,
                                    'studentImg'  => $this->order?->userProfile?->image,
                                    'courseTitle' => $booking->orderable?->title,
                                    'coursePrice' => $booking->orderable?->pricing?->price,
                                ];
                            }elseif(\Nwidart\Modules\Facades\Module::has('CourseBundles') && \Nwidart\Modules\Facades\Module::isEnabled('CourseBundles') && $booking->orderable instanceof \Modules\CourseBundles\Models\Bundle) {
                                $emailData['tutorName'] = $booking->orderable->instructor?->profile?->full_name;
                                $tutorForEmail = $booking->orderable->instructor;
                                foreach($booking->orderable->courses as $course) {
                                    $alreadyHaveCourse = (new \Modules\Courses\Services\CourseService())->getStudentCourse(
                                        courseId: $course->id, 
                                        studentId: $this->order?->user_id,
                                        tutorId: $course->instructor_id
                                    );
                                    if ($alreadyHaveCourse) {
                                        continue;
                                    }
                                    $emailData['courses'][]=[
                                        'studentName' => $this->order?->userProfile?->full_name,
                                        'studentImg'  => $this->order?->userProfile?->image,
                                        'courseTitle' => $course?->title,
                                        'coursePrice' => $course?->pricing?->price,
                                    ];
                                }
                            }
                        }
                        dispatch(new SendNotificationJob('sessionBooking',$tutorForEmail, $emailData));
                        dispatch(new SendDbNotificationJob('sessionBooking', $tutorForEmail, ['bookingLink' => route('tutor.bookings.upcoming-bookings')]));
                    }
                }

                //Student bookings
                $emailData = [];
                $emailData['emailFor']  = 'student';
                $emailData['studentName'] = $this->order?->userProfile?->full_name;
                foreach ($this->order?->items as $item) {
                    if($item->orderable instanceof SlotBooking) {
                        $emailData['bookings'][] = [
                            'tutorName'   => $item->orderable?->tutor?->full_name,
                            'tutorImg'    => $item->orderable?->tutor?->image,
                            'subjectName' => $item->options['subject_group'] . ' <br /> ' . $item->options['subject'],
                            'sessionTime' => $this->bookingService->getBookingTime($item->orderable, 'booker', true)
                        ];
                    } elseif(Module::has('courses') && Module::isEnabled('courses') && $item->orderable instanceof \Modules\Courses\Models\Course) {
                        $emailData['studentName'] = $this->order?->userProfile?->full_name;
                        $emailData['courses'][] = [
                            'tutorName'   => $item->orderable?->instructor?->profile?->full_name,
                            'tutorImg'    => $item->orderable?->instructor?->profile?->image,
                            'courseTitle' => $item->orderable?->title,
                            'coursePrice' => $item->orderable?->pricing?->price,
                        ];
                    }elseif(\Nwidart\Modules\Facades\Module::has('CourseBundles') && \Nwidart\Modules\Facades\Module::isEnabled('CourseBundles') && $booking->orderable instanceof \Modules\CourseBundles\Models\Bundle) {
                        $emailData['studentName'] = $this->order?->userProfile?->full_name;
                        foreach($booking->orderable->courses as $course) {
                            $alreadyHaveCourse = (new \Modules\Courses\Services\CourseService())->getStudentCourse(
                                courseId: $course->id, 
                                studentId: $this->order?->user_id,
                                tutorId: $course->instructor_id
                            );
                            if ($alreadyHaveCourse) {
                                continue;
                            }
                            $emailData['courses'][]=[
                                'tutorName'   => $item->orderable?->instructor?->profile?->full_name,
                                'tutorImg'    => $item->orderable?->instructor?->profile?->image,
                                'courseTitle' => $course?->title,
                                'coursePrice' => $course?->pricing?->price,
                            ];
                        }
                    }


                }

                if (!empty($emailData['courses']) || !empty($emailData['bookings'])) {
                    dispatch(new SendNotificationJob('sessionBooking', $this->order?->orderBy, $emailData));
                    dispatch(new SendDbNotificationJob('sessionBooking', $this->order?->orderBy, ['bookingLink' => route('student.bookings')]));
                }


                DB::commit();
            }


        } catch (Exception $ex) {
            throw new Exception($ex);
            DB::rollBack();
        }

    }
}
