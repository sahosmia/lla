<?php

namespace App\Jobs;

use App\Models\Order;
use App\Models\SlotBooking;
use App\Models\User;
use App\Services\BookingService;
use App\Services\OrderService;
use App\Services\WalletService;
use Carbon\Carbon;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Nwidart\Modules\Facades\Module;

class CompletePurchaseJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected Order $order;
    protected BookingService $bookingService;
    protected OrderService $orderService;
    protected WalletService $walletService;

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
    public function handle(BookingService $bookingService, OrderService $orderService, WalletService $walletService): void
    {
        try {
            $this->bookingService   = $bookingService;
            $this->orderService     = $orderService;
            $this->walletService    = $walletService;
            $studentSubscription = $tutorSubscriptions = null;
            $studentRemainingCredits = $tutorRemainingCredits = [];
            if (Module::has('subscriptions') && Module::isEnabled('subscriptions') && !empty($this->order->subscription_id)) {
               $studentSubscription = (new \Modules\Subscriptions\Services\SubscriptionService())->getUserSubscription(userId:$this->order->user_id, subscriptionId: $this->order->subscription_id);
               $studentRemainingCredits = $studentSubscription?->remaining_credits ?? [];
            }
            $tutorBookings = $tutorFunds = [];

            DB::beginTransaction();
            if (!empty($this->order->items)) {
                foreach($this->order->items as $item) {
                    if ($item->orderable instanceof SlotBooking) {

                        $this->bookingService->updateBooking($item->orderable, ['status' => 'active']);
                        $this->bookingService->addBookingLog($item->orderable, [
                            'activityable_id'   => $item->orderable->student_id,
                            'activityable_type' => User::class,
                            'type'              => 'active'
                        ]);

                        //Calculate tutor funds
                        $platformFee = getCommission($item->total);

                        $tutorEarning = $item->total - $platformFee;
                        
                        if (Module::has('subscriptions') && Module::isEnabled('subscriptions')) {
                            if (!empty($this->order->subscription_id)) {
                                if ( !empty($studentSubscription) && ($studentRemainingCredits['sessions'] ?? 0) > 0) {
                                    $studentRemainingCredits['sessions'] = $studentRemainingCredits['sessions'] - 1;
                                    $tutorEarning = (new \Modules\Subscriptions\Services\SubscriptionService())->getSubscriptionTutorPayout($studentSubscription);
                                    $platformFee = 0;
                                }   
                            } else {
                                $tutorSubscription = (new \Modules\Subscriptions\Services\SubscriptionService())->getUserSubscription(userId:$item->orderable?->bookee?->id)->first();
                                $tutorRemainingCredits[$tutorSubscription?->id] = $tutorSubscription?->remaining_credits ?? [];
                                if(!empty($tutorSubscription) && ($tutorRemainingCredits[$tutorSubscription?->id]['sessions'] ?? 0) > 0) {
                                    $tutorRemainingCredits[$tutorSubscription?->id]['sessions'] = $tutorRemainingCredits[$tutorSubscription?->id]['sessions'] - 1;
                                    $tutorEarning = $item->price;
                                    $platformFee = 0;
                                }
                                $tutorSubscriptions[] = $tutorSubscription;
                            }
                        }

                        //Update platform fee in order_items table
                        $this->orderService->updateOrderItem($item, ['platform_fee'=> $platformFee, 'options' => array_merge($item->options, ['tutor_payout' => $tutorEarning])]);
                        $tutorFunds[$item->orderable?->bookee?->id] = ($tutorFunds[$item->orderable?->bookee?->id]??0) + $tutorEarning ;

                        //Update tutorBookings
                        $tutorBookings[$item->orderable?->bookee?->id][] = $item;

                        $this->bookingService->createBookingEventGoogleCalendar($item->orderable);
                        $this->bookingService->createSlotEventGoogleCalendar($item->orderable);
                        $this->bookingService->createMeetingLink($item->orderable);
                        // Calculate delay until the end time of the booking
                        $endTime = $item->orderable?->end_time;
                        $delay = now()->diffInSeconds($endTime, false);
                        if ($delay > 0) {
                            dispatch(new SendNotificationJob('bookingCompletionRequest',$item->orderable?->booker, [
                                'tutorName'           => $item->orderable?->tutor?->full_name,
                                'userName'            => $item->orderable?->student?->full_name,
                                'sessionDateTime'     => $this->bookingService->getBookingTime($item->orderable, 'booker'),
                                'completeBookingLink' => route('student.complete-booking', $item->orderable?->id),
                                'days'                => setting('_lernen.complete_booking_after_days') ?? 3    
                            ]))->delay($delay);
                            
                            dispatch(new SendDbNotificationJob('bookingCompletionRequest', $item->orderable?->booker, [
                                'tutorName'           => $item->orderable?->tutor?->full_name,
                                'sessionDateTime'     => $this->bookingService->getBookingTime($item->orderable, 'booker'),
                                'completeBookingLink' => route('student.complete-booking', $item->orderable?->id),
                                'days'                => setting('_lernen.complete_booking_after_days') ?? 3    
                            ]))->delay($delay);
                        }

                        $completeBookingDelay = Carbon::parse($endTime)->addDays((int)setting('_lernen.complete_booking_after_days') ?? 3);
                        dispatch(new CompleteBookingJob($item->orderable))->delay($completeBookingDelay);
                    } elseif(\Nwidart\Modules\Facades\Module::has('courses') && \Nwidart\Modules\Facades\Module::isEnabled('courses') && $item->orderable instanceof \Modules\Courses\Models\Course) {
                        $tutorBookings[$item->orderable?->instructor_id][] = $item;
                        //Calculate tutor funds
                        $platformFee = getCommission($item->total, 'courses');
                        $tutorEarning = $item->total - $platformFee;

                        if (Module::has('subscriptions') && Module::isEnabled('subscriptions')) {
                            if (!empty($this->order->subscription_id)) {
                                if ( !empty($studentSubscription) && ($studentRemainingCredits['courses'] ?? 0) > 0) {
                                    $studentRemainingCredits['courses'] = $studentRemainingCredits['courses'] - 1;
                                    $tutorEarning = (new \Modules\Subscriptions\Services\SubscriptionService())->getSubscriptionTutorPayout($studentSubscription, 'courses');
                                    $platformFee = 0;
                                }
                            } else {
                                $tutorSubscription = (new \Modules\Subscriptions\Services\SubscriptionService())->getUserSubscription(userId:$item->orderable?->instructor_id)->first();
                                $tutorRemainingCredits[$tutorSubscription?->id] = $tutorSubscription?->remaining_credits ?? [];
                                if(!empty($tutorSubscription) && ($tutorRemainingCredits[$tutorSubscription?->id]['courses'] ?? 0) > 0) {
                                    $tutorRemainingCredits[$tutorSubscription?->id]['courses'] = $tutorRemainingCredits[$tutorSubscription?->id]['courses'] - 1;
                                    $tutorEarning = $item->price;
                                    $platformFee = 0;
                                }
                                $tutorSubscriptions[] = $tutorSubscription;
                            }
                        }

                        $tutorFunds[$item->orderable?->instructor_id] = ($tutorFunds[$item->orderable?->instructor_id]??0) + $tutorEarning ;
                        $this->orderService->updateOrderItem($item, ['platform_fee'=> $platformFee, 'options' => array_merge($item->options, ['tutor_payout' => $tutorEarning])]);
                        if(!empty($item->orderable)) {
                            $courseData = [
                                'student_id'        => $this->order?->user_id,
                                'course_id'         => $item->orderable?->id,
                                'tutor_id'          => $item->orderable?->instructor_id,
                                'course_price'      => $item->orderable?->pricing?->price,
                                'course_discount'   => $item->orderable?->pricing?->discount,
                                'status'            => 'active',
                            ];
                            (new \Modules\Courses\Services\CourseService())->addStudentCourse($courseData);
                            $completeCourseDelay = Carbon::parse(now())->addDays((int)setting('_lernen.clear_course_amount_after_days') ?? 3);
                            dispatch(new \Modules\Courses\Jobs\ClearCourseFundsJob($item->orderable?->instructor_id, $tutorEarning, $this->order->id))->delay($completeCourseDelay);
                        }
                    } elseif(\Nwidart\Modules\Facades\Module::has('CourseBundles') && \Nwidart\Modules\Facades\Module::isEnabled('CourseBundles') && $item->orderable instanceof \Modules\CourseBundles\Models\Bundle) {    
                        $bundleCourses = $item->orderable->courses;
                        $tutorBookings[$item->orderable?->instructor_id][] = $item;
                        $platformFee = getCommission($item->total, 'course_bundles');
                        $tutorEarning = $item->total - $platformFee;
                        $tutorFunds[$item->orderable?->instructor_id] = ($tutorFunds[$item->orderable?->instructor_id]??0) + $tutorEarning ;
                        $this->orderService->updateOrderItem($item, ['platform_fee'=> $platformFee, 'options' => array_merge($item->options, ['tutor_payout' => $tutorEarning])]);
                        (new \Modules\CourseBundles\Services\BundleService())->addBundlePurchase([
                            'student_id'        => $this->order?->user_id,
                            'tutor_id'          => $item->orderable?->instructor_id,
                            'bundle_id'         => $item->orderable?->id,
                            'purchased_price'   => $item->orderable?->final_price
                        ]);
                        if (!empty($bundleCourses)) {
                            foreach ($bundleCourses as $course) {
                                $alreadyHaveCourse = (new \Modules\Courses\Services\CourseService())->getStudentCourse(
                                    courseId: $course->id, 
                                    studentId: $this->order?->user_id,
                                    tutorId: $course->instructor_id
                                );
                                if ($alreadyHaveCourse) {
                                    continue;
                                }
                                $courseData = [
                                    'student_id'        => $this->order?->user_id,
                                    'course_id'         => $course->id,
                                    'tutor_id'          => $course->instructor_id,
                                    'course_price'      => $course->pricing?->price,
                                    'course_discount'   => $course?->pricing?->discount,
                                    'status'            => 'active',
                                ];
                                (new \Modules\Courses\Services\CourseService())->addStudentCourse($courseData);
                            }
                        }

                        $completeCourseDelay = Carbon::parse(now())->addDays((int)setting('_coursebundle.clear_course_bundle_amount_after_days') ?? 3);
                        dispatch(new \Modules\Courses\Jobs\ClearCourseFundsJob($item->orderable?->instructor_id, $tutorEarning, $this->order->id))->delay($completeCourseDelay);
                    } elseif(Module::has('subscriptions') && Module::isEnabled('subscriptions') && $item->orderable instanceof \Modules\Subscriptions\Models\Subscription) {
                        if ($item->orderable?->role_id == getRoleByName('tutor')) {
                            $tutorBookings[$this->order?->user_id][] = $item;
                        }
                        if(!empty($item->orderable?->revenue_share['admin_share'])){
                            $platformFee = $item->orderable?->price * $item->orderable?->revenue_share['admin_share'] / 100;
                        } else {
                            $platformFee = $item->orderable?->price;
                        }
                        $this->orderService->updateOrderItem($item, ['platform_fee' => $platformFee]);
                        $subscriptionData = [
                            'user_id'           => $this->order->user_id,
                            'order_item_id'     => $item->id,
                            'subscription_id'   => $item->orderable?->id,
                            'price'             => $item->orderable?->price,
                            'credit_limits'     => $item->orderable?->credit_limits,
                            'remaining_credits' => $item->orderable?->credit_limits,
                            'auto_renew'        => $item->orderable?->auto_renew,
                            'expires_at'        => getSubscriptionExpiry($item->orderable),
                            'revenue_share'     => $item->orderable?->revenue_share,
                            'status'            => 'active'
                        ];
                        $userSubscription = (new \Modules\Subscriptions\Services\SubscriptionService())->addUserSubscription($subscriptionData);
                        $expiryDate        = getSubscriptionExpiry($item->orderable);
                        if ($item->orderable?->auto_renew == 'yes') {
                            $daysToSubtract    = (int)setting('_lernen.notify_subscription_expiry_before_days') ?? 0;
                            $notificationDelay = Carbon::parse($expiryDate)->subDays($daysToSubtract);
                            dispatch(new \Modules\Subscriptions\Jobs\SubscriptionRenewNotificationJob($userSubscription))->delay($notificationDelay);
                        }
                        dispatch(new \Modules\Subscriptions\Jobs\SubscriptionExpiryJob($userSubscription))->delay($expiryDate);
                    }
                }

                if (!empty($tutorFunds)) {
                    foreach ($tutorFunds as $tutorId => $amount) {
                        $walletService->pendingAvailableFunds( $tutorId, $amount, $this->order->id);
                    }
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
                            } elseif (Module::has('subscriptions') && Module::isEnabled('subscriptions') && $booking->orderable instanceof \Modules\Subscriptions\Models\Subscription) {
                                $emailData['tutorName'] = $this->order?->userProfile?->full_name;
                                $tutorForEmail = $this->order?->orderBy;
                                $emailData['subscriptions'][] = [
                                    'subscriptionName'   => $item->orderable?->name,
                                    'subscriptionPrice'  => $item->orderable?->price,
                                    'subscriptionPeriod' => $item->orderable?->period,
                                    'expires_at'         => getSubscriptionExpiry($item->orderable)
                                ];
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
                    } elseif(Module::has('subscriptions') && Module::isEnabled('subscriptions') && $item->orderable instanceof \Modules\Subscriptions\Models\Subscription && $item->orderable?->role_id == getRoleByName('student')) {
                        $emailData['subscriptions'][] = [
                            'subscriptionName'   => $item->orderable?->name,
                            'subscriptionPrice'  => $item->orderable?->price,
                            'subscriptionPeriod' => $item->orderable?->period,
                            'expires_at'         => getSubscriptionExpiry($item->orderable)
                        ];
                    }
                }
                
                if (!empty($emailData['subscriptions']) || !empty($emailData['courses']) || !empty($emailData['bookings'])) {
                    dispatch(new SendNotificationJob('sessionBooking', $this->order?->orderBy, $emailData));
                    dispatch(new SendDbNotificationJob('sessionBooking', $this->order?->orderBy, ['bookingLink' => route('student.bookings')]));
                }

                if(!empty($tutorSubscriptions)){
                    foreach($tutorSubscriptions as $tutorSubscription){
                        if(Module::has('subscriptions') && Module::isEnabled('subscriptions') && !empty($tutorSubscription)) {
                            (new \Modules\Subscriptions\Services\SubscriptionService())->updateUserSubscription($tutorSubscription->user_id, $tutorSubscription->subscription_id, ['remaining_credits' => $tutorRemainingCredits[$tutorSubscription?->id]]);
                        }
                    }
                }

                if(Module::has('subscriptions') && Module::isEnabled('subscriptions') && !empty($studentSubscription)) {
                    (new \Modules\Subscriptions\Services\SubscriptionService())->updateUserSubscription($studentSubscription->user_id, $studentSubscription->subscription_id, ['remaining_credits' => $studentRemainingCredits]);
                }

                DB::commit();
            }


        } catch (Exception $ex) {
            throw new Exception($ex);
            DB::rollBack();
        }

    }
}
