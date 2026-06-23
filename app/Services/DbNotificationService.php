<?php

namespace App\Services;

use App\Models\NotificationTemplate;
use App\Notifications\DbNotification;
use Illuminate\Support\Str;

class DbNotificationService
{
    public function send($user, $data)
    {
        $user->notify(new DbNotification($data));
    }

    public function getUserNotifications($user, $limit = 5)
    {
        return $user->notifications()->latest()->take($limit)->get();
    }

    public function getUserNotificationsPaginated($user)
    {
        return $user->notifications()->latest()->paginate(setting('_general.per_page_record') ?? 10);
    }

    public function markAsRead($user, $id)
    {
        $notification = $user->notifications()->find($id);
        if ($notification) {
            $notification->markAsRead();
        }
    }

    public function markAllAsRead($user)
    {
        $user->unreadNotifications->markAsRead();
    }

    public function dispatch($type, $user, $data)
    {
        $notificationTemplate = $this->parseNotificationTemplate($type, $user->role, $data);
        if ($notificationTemplate) {
            unset($notificationTemplate['info']);
            $user->notify(new DbNotification($notificationTemplate));
        }
    }

    public function getNotificationTemplate($type = '', $role = ''): array | NULL
    {
        return NotificationTemplate::where(function ($query) use ($type, $role) {
            $query->whereType($type);
            if ($role)
                $query->whereRole($role);
            $query->whereStatus('active');
        })->first()?->toArray();
    }


    public function parseNotificationTemplate($type, $role, $data)
    {
        $emailTemplate = array();
        $template = $this->getNotificationTemplate($type, $role);
        if ($template) {
            $content = $template['content'];
            $parseFunction = (string)"get" . Str::ucfirst(Str::camel($type)) . "Notification";
            $emailTemplate = $this->$parseFunction($content, $data);
        }

        return $emailTemplate;
    }

    public function getIdentityVerificationApprovedNotification($content, $data)
    {
        $notificationTemplate = array();
        foreach ($content as $key => &$value) {
            $content[$key] = Str::replace('{userName}', $data['userName'], $value);
        }
        $notificationTemplate = $content;
        return $notificationTemplate;
    }

    public function getIdentityVerificationRejectedNotification($content, $data)
    {
        $notificationTemplate = array();
        foreach ($content as $key => &$value) {
            $content[$key] = Str::replace('{userName}', $data['userName'], $value);
        }
        $notificationTemplate = $content;
        return $notificationTemplate;
    }

    public function getSessionBookingNotification($content, $data)
    {
        $emailTemplate = $content;

        if (Str::contains($emailTemplate['content'], '{bookingLink}')) {
            $emailTemplate['has_link']      = true;
            $emailTemplate['link_target']   = $data['bookingLink'];
            $emailTemplate['link_text']     = __('notification_template.view_booking');
            $emailTemplate['content']       = Str::replace("{bookingLink}", '', $emailTemplate['content']);   
        }

        return $emailTemplate;
    }

    public function getBookingRescheduledNotification($content, $data)
    {
        $emailTemplate = array();
        foreach ($content as $key => &$value) {
            $content[$key] = Str::replace('{tutorName}', $data['tutorName'], $value);
            $content[$key] = Str::replace('{userName}', $data['userName'], $value);
            $content[$key] = Str::replace('{reason}', $data['reason'], $value);
            $content[$key] = Str::replace('{newSessionDate}', $data['newSessionDate'], $value);
        }
        $emailTemplate = $content;
        if (Str::contains($emailTemplate['content'], '{viewLink}')) {
            $emailTemplate['has_link']      = true;
            $emailTemplate['link_target']   = $data['viewLink'];
            $emailTemplate['link_text']     = __('quiz::quiz.reschedule_booking');
            $emailTemplate['content']       = Str::replace("{viewLink}", '', $emailTemplate['content']);
        }
        return $emailTemplate;
    }

    public function getAcceptedWithdrawRequestNotification($content, $data)
    {
        $emailTemplate = array();
        foreach ($content as $key => &$value) {
            $content[$key] = Str::replace('{withdrawAmount}', $data['withdrawAmount'], $value);
        }
        $emailTemplate = $content;
        return $emailTemplate;
    }

    public function getNewMessageNotification($content, $data)
    {
        $emailTemplate = array();
        foreach ($content as $key => &$value) {
            $content[$key] = Str::replace('{messageSender}', $data['messageSender'], $value);
        }
        $emailTemplate = $content;
        return $emailTemplate;
    }

    public function getBookingLinkGeneratedNotification($content, $data)
    {
        $emailTemplate = array();
        foreach ($content as $key => &$value) {
            $content[$key] = Str::replace('{tutorName}', $data['tutorName'] ?? '', $value);
            $content[$key] = Str::replace('{sessionDate}', $data['sessionDate'] ?? '', $value);
            $content[$key] = Str::replace('{sessionSubject}', $data['sessionSubject'] ?? '', $value);
        }
        $emailTemplate = $content;
        if (Str::contains($emailTemplate['content'], '{meetingLink}')) {
            $emailTemplate['has_link']      = true;
            $emailTemplate['link_target']   = $data['meetingLink'];
            $emailTemplate['link_text']     = __('quiz::quiz.booking');
            $emailTemplate['content']       = Str::replace("{meetingLink}", '', $emailTemplate['content']);
        }
        return $emailTemplate;
    }

    public function getBookingCompletionRequestNotification($content, $data)
    {
        $emailTemplate = array();
        foreach ($content as $key => &$value) {
            $content[$key] = Str::replace('{tutorName}', $data['tutorName'] ?? '', $value);
            $content[$key] = Str::replace('{sessionDateTime}', $data['sessionDateTime'] ?? '', $value);
            $content[$key] = Str::replace('{days}', $data['days'] ?? '', $value);
        }
        $emailTemplate = $content;
        if (Str::contains($emailTemplate['content'], '{completeBookingLink}')) {
            $emailTemplate['has_link']      = true;
            $emailTemplate['link_target']   = $data['completeBookingLink'];
            $emailTemplate['link_text']     = __('quiz::quiz.complete_booking');
            $emailTemplate['content']       = Str::replace("{completeBookingLink}", '', $emailTemplate['content']);
        }
        return $emailTemplate;
    }

    public function getSessionRequestNotification($content, $data)
    {
        $emailTemplate = array();
        foreach ($content as $key => &$value) {
            $content[$key] = Str::replace('{studentName}', $data['studentName'] ?? '', $value);
            $content[$key] = Str::replace('{studentEmail}', $data['studentEmail'] ?? '', $value);
            $content[$key] = Str::replace('{sessionType}', $data['sessionType'] ?? '', $value);
            $content[$key] = Str::replace('{message}', $data['message'] ?? '', $value);
        }
        $emailTemplate = $content;
        return $emailTemplate;
    }

    public function getDisputeResolutionNotification($content, $data)
    {
        $emailTemplate = array();
        foreach ($content as $key => &$value) {
            $content[$key] = Str::replace('{studentName}', $data['studentName'], $value);
            $content[$key] = Str::replace('{tutorName}', $data['tutorName'], $value);
            $content[$key] = Str::replace('{sessionDateTime}', \Carbon\Carbon::parse($data['sessionDateTime'])->format('F j, Y, g:i A'), $value);
            $content[$key] = Str::replace('{paymentAmount}', $data['paymentAmount'], $value);
            $content[$key] = Str::replace('{disputeReason}', $data['disputeReason'], $value);
        }
        $emailTemplate = $content;
        return $emailTemplate;
    }

    public function getAssignedQuizNotification($content, $data)
    {
       
        $emailTemplate = array();
        foreach ($content as $key => &$value) {
            $content[$key] = Str::replace('{studentName}', $data['studentName'], $value);
            $content[$key] = Str::replace('{tutorName}', $data['tutorName'], $value);
            $content[$key] = Str::replace('{quizName}', $data['quizTitle'], $value);
        }
        $emailTemplate = $content;
        if (Str::contains($emailTemplate['content'], '{assignedQuizUrl}')) {
            $emailTemplate['has_link']      = true;
            $emailTemplate['link_target']   = $data['assignedQuizUrl'];
            $emailTemplate['link_text']     = __('quiz::quiz.view_quiz');
            $emailTemplate['content']       = Str::replace("{assignedQuizUrl}", '', $emailTemplate['content']);
        }
        return $emailTemplate;
    }

    public function getReviewedQuizNotification($content, $data)
    {
        $emailTemplate = array();
        foreach ($content as $key => &$value) {
            $content[$key] = Str::replace('{studentName}', $data['studentName'], $value);
            $content[$key] = Str::replace('{tutorName}', $data['tutorName'], $value);
            $content[$key] = Str::replace('{quizName}', $data['quizTitle'], $value);
        }
        $emailTemplate = $content;
        return $emailTemplate;
    }

    public function getGenerateQuizResultNotification($content, $data)
    {
        $emailTemplate = array();
        foreach ($content as $key => &$value) {
            $content[$key] = Str::replace('{studentName}', $data['studentName'], $value);
            $content[$key] = Str::replace('{tutorName}', $data['tutorName'], $value);
            $content[$key] = Str::replace('{quizName}', $data['quizTitle'], $value);
        }
        $emailTemplate = $content;
        if (Str::contains($emailTemplate['content'], '{quizResultUrl}')) {
            $emailTemplate['has_link']      = true;
            $emailTemplate['link_target']   = $data['quizResultUrl'];
            $emailTemplate['link_text']     = __('quiz::quiz.view_result');
            $emailTemplate['content']       = Str::replace("{quizResultUrl}", '', $emailTemplate['content']);
        }
        return $emailTemplate;
    }

    public function getRenewSubscriptionNotification($content, $data)
    {
        $emailTemplate = array();
        foreach ($content as $key => &$value) {
            $content[$key] = Str::replace('{userName}', $data['userName'] ?? '', $value);
            $content[$key] = Str::replace('{subscriptionName}', $data['subscriptionName'] ?? '', $value);
            $content[$key] = Str::replace('{subscriptionExpiry}', $data['subscriptionExpiry'] ?? '', $value);
        }
        $emailTemplate = $content;
        if (Str::contains($emailTemplate['content'], '{renewalLink}')) {
            $emailTemplate['has_link']      = true;
            $emailTemplate['link_target']   = $data['renewalLink'];
            $emailTemplate['link_text']     = __('subscriptions::subscription.renew_subscription_btn');
            $emailTemplate['content']       = Str::replace("{renewalLink}", '', $emailTemplate['content']);
        }
        return $emailTemplate;
    }

    
    public function getAssignedAssignmentNotification($content, $data)
    {
        $emailTemplate = array();
        foreach ($content as $key => &$value) {
            $content[$key] = Str::replace('{studentName}', $data['studentName'], $value);
            $content[$key] = Str::replace('{tutorName}', $data['tutorName'], $value);
            $content[$key] = Str::replace('{assignmentName}', $data['assignmentTitle'], $value);
        }
        $emailTemplate = $content;
        if (Str::contains($emailTemplate['content'], '{assignedAssignmentUrl}')) {
            $emailTemplate['has_link']      = true;
            $emailTemplate['link_target']   = $data['assignedAssignmentUrl'];
            $emailTemplate['link_text']     = __('assignments::assignments.view_assignment');
            $emailTemplate['content']       = Str::replace("{assignedAssignmentUrl}", '', $emailTemplate['content']);
        }
        return $emailTemplate;
    }

    public function getReviewedAssignmentNotification($content, $data)
    {
        $emailTemplate = array();
        foreach ($content as $key => &$value) {
            $content[$key] = Str::replace('{studentName}', $data['studentName'], $value);
            $content[$key] = Str::replace('{tutorName}', $data['tutorName'], $value);
            $content[$key] = Str::replace('{assignmentName}', $data['assignmentTitle'], $value);
        }
        $emailTemplate = $content;
        if (Str::contains($emailTemplate['content'], '{reviewedAssignmentUrl}')) {
            $emailTemplate['has_link']      = true;
            $emailTemplate['link_target']   = $data['reviewedAssignmentUrl'];
            $emailTemplate['link_text']     = __('assignments::assignments.review_assignment');
            $emailTemplate['content']       = Str::replace("{reviewedAssignmentUrl}", '', $emailTemplate['content']);
        }
        return $emailTemplate;
    }

    public function getGenerateAssignmentResultNotification($content, $data)
    {
        $emailTemplate = array();
        foreach ($content as $key => &$value) {
            $content[$key] = Str::replace('{studentName}', $data['studentName'], $value);
            $content[$key] = Str::replace('{tutorName}', $data['tutorName'], $value);
            $content[$key] = Str::replace('{assignmentName}', $data['assignmentTitle'], $value);
        }
        $emailTemplate = $content;
        if (Str::contains($emailTemplate['content'], '{assignmentResultUrl}')) {
            $emailTemplate['has_link']      = true;
            $emailTemplate['link_target']   = $data['assignmentResultUrl'];
            $emailTemplate['link_text']     = __('assignments::assignments.view_result');
            $emailTemplate['content']       = Str::replace("{assignmentResultUrl}", '', $emailTemplate['content']);
        }
        return $emailTemplate;
    }
}
