<?php

namespace App\Jobs;

use App\Services\BookingService;
use App\Services\WalletService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;


class CompleteBookingJob implements ShouldQueue
{
    use Queueable;

    public $booking;
    /**
     * Create a new job instance.
     */
    public function __construct($booking)
    {
        $this->booking = $booking;
    }

    /**
     * Execute the job.
     */
    public function handle(BookingService $bookingService, WalletService $walletService): void
    {
        if ($this->booking->status == 'active') {
            $bookingService->updateBooking($this->booking, ['status' => 'completed']);
            $walletService->makePendingFundsAvailable($this->booking->tutor_id, ($this->booking->session_fee - $this->booking?->orderItem?->platform_fee), $this->booking?->orderItem?->order_id);
            $template_id = $this->booking->slot?->meta_data['template_id'] ?? null;

            if (\Nwidart\Modules\Facades\Module::has('upcertify') && \Nwidart\Modules\Facades\Module::isEnabled('upcertify') && !empty($template_id)) {
                $metaData = $this->booking->slot?->meta_data;
                if (isActiveModule('Quiz')) {
                    if (!empty($metaData['assign_quiz_certificate']) && $metaData['assign_quiz_certificate'] == 'none') {
                        dispatch(new GenerateCertificateJob($this->booking));
                    }
                } else {
                    dispatch(new GenerateCertificateJob($this->booking));
                }
            }
            if (isActiveModule('quiz')) {
                $quizzes = (new \Modules\Quiz\Services\QuizService())->quizzsBySlot($this->booking->user_subject_slot_id);
                if ($quizzes->isNotEmpty()) {
                    foreach ($quizzes as $quiz) {
                        if ($quiz->status == 'published') {

                            $quizDetail = (new \Modules\Quiz\Services\QuizService())->assignQuiz($quiz?->id, [$this->booking->student_id]);

                            $emailData = [
                                'quizTitle'       => $quiz->title,
                                'studentName'     => $this->booking->student?->full_name,
                                'tutorName'       => $quiz?->tutor?->profile?->full_name,
                                'quizUrl'         => route('quiz.student.quiz-details', ['attemptId' => $quizDetail->id])
                            ];

                            $notifyData = [
                                'quizTitle'         => $quiz->title,
                                'studentName'       => $this->booking->student?->full_name,
                                'tutorName'         => $quiz?->tutor?->profile?->full_name,
                                'assignedQuizUrl'   => route('quiz.student.quizzes')
                            ];

                            dispatch(new SendNotificationJob('assignedQuiz', $this->booking->booker, $emailData));
                            dispatch(new SendDbNotificationJob('assignedquiz', $this->booking->booker, $notifyData));
                        }
                    }
                }
            }

            if (isActiveModule('assignments')) {
                $assignments = (new \Modules\Assignments\Services\AssignemntsService())->assignmentsBySlot($this->booking->user_subject_slot_id);
                if ($assignments->isNotEmpty()) {
                    foreach ($assignments as $assignment) {
                        if ($assignment->status == 'published') {

                            $assignmentDetail = (new \Modules\Assignments\Services\AssignemntsService())->assignAssignment($assignment?->id, [$this->booking->student_id]);

                            $emailData = [
                                'assignmentTitle'       => $assignment->title,
                                'studentName'           => $this->booking->student?->full_name,
                                'tutorName'             => $assignment?->tutor?->profile?->full_name,
                                'assignedAssignmentUrl' => route('assignments.student.attempt-assignment', ['id' => $assignmentDetail?->id])
                            ];  

                            $notifyData = [
                                'assignmentTitle'       => $assignment->title,                                        
                                'studentName'           => $this->booking->student?->full_name,
                                'tutorName'             => $assignment?->tutor?->profile?->full_name,   
                                'assignedAssignmentUrl' => route('assignments.student.attempt-assignment', ['id' => $assignmentDetail?->id])
                            ];

                            dispatch(new SendNotificationJob('assignedAssignment', $this->booking->booker, $emailData));
                            dispatch(new SendDbNotificationJob('assignedassignment', $this->booking->booker, $notifyData));
                        }
                    }
                }
            }
        }
    }
}
