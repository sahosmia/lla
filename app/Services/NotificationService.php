<?php

namespace App\Services;

use App\Models\EmailTemplate;
use Illuminate\Support\Str;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

class NotificationService
{

    public function getEmailTemplate($type = '', $role = ''): array | NULL
    {
        return EmailTemplate::where(function ($query) use ($type, $role) {
            $query->whereType($type);
            if ($role)
                $query->whereRole($role);
            $query->whereStatus('active');
        })->first()?->toArray();
    }


    public function parseEmailTemplate($type, $role, $data)
    {
        
        $emailTemplate = array();
        $template = $this->getEmailTemplate($type, $role);
        
        if ($template) {
            $content = $template['content'];
            $parseFunction = (string)"get" . Str::ucfirst(Str::camel($type)) . "Email";
            
            $emailTemplate = $this->$parseFunction($content, $data);
        }
        return $emailTemplate;
    }

    public function getRegistrationEmail($content, $data)
    {
        $emailTemplate = array();
        foreach ($content as $key => &$value) {
            $content[$key] = Str::replace('{userName}', $data['userName'], $value);
            $content[$key] = Str::replace('{userEmail}', $data['userEmail'], $value);
        }
        $emailTemplate = $content;
        if (Str::contains($emailTemplate['content'], '{verificationLink}')) {
            $verifyUrl = URL::temporarySignedRoute(
                'verification.verify',
                Carbon::now()->addMinutes(1440),
                [
                    'id' => $data['key'],
                    'hash' => sha1($data['userEmail']),
                ]
            );
            $btnHtml = view('components.email.button', ['btnText' => trans('email_template.verfiy_email'), 'btnUrl' => $verifyUrl])->render();
            $emailTemplate['content'] = Str::replace('{verificationLink}', $btnHtml, $emailTemplate['content']);
        }
        return $emailTemplate;
    }

    public function getWelcomeEmail($content, $data)
    {
        $emailTemplate = array();
        foreach ($content as $key => &$value) {
            $content[$key] = Str::replace('{userName}', $data['userName'], $value);
            $content[$key] = Str::replace('{userEmail}', $data['userEmail'], $value);
        }
        $emailTemplate = $content;
        
        return $emailTemplate;
    }

    public function getEmailVerificationEmail($content, $data)
    {
        $emailTemplate = array();
        foreach ($content as $key => &$value) {
            $content[$key] = Str::replace('{userName}', $data['userName'], $value);
            $content[$key] = Str::replace('{userEmail}', $data['userEmail'], $value);
        }
        $emailTemplate = $content;
        if (Str::contains($emailTemplate['content'], '{verificationLink}')) {
            $verifyUrl = URL::temporarySignedRoute(
                'verification.verify',
                Carbon::now()->addMinutes(1440),
                [
                    'id' => $data['key'],
                    'hash' => sha1($data['userEmail']),
                ]
            );
            $btnHtml = view('components.email.button', ['btnText' => trans('email_template.verfiy_email'), 'btnUrl' => $verifyUrl]);
            $emailTemplate['content'] = Str::replace('{verificationLink}', $btnHtml, $emailTemplate['content']);
        }
        return $emailTemplate;
    }

    public function getPasswordResetRequestEmail($content, $data)
    {
        $emailTemplate = array();
        foreach ($content as $key => &$value) {
            $content[$key] = Str::replace('{userName}', $data['userName'], $value);
        }
        $emailTemplate = $content;
        if (Str::contains($emailTemplate['content'], '{resetLink}')) {
            $btnUrl = url(route('password.reset', [
                'token' => $data['token'],
                'email' => $data['userEmail'],
            ], false));
            $btnHtml = view('components.email.button', ['btnText' => trans('email_template.reset_password_txt'), 'btnUrl' => $btnUrl]);
            $emailTemplate['content']    = Str::replace("{resetLink}", $btnHtml, $emailTemplate['content']);
        }
        return $emailTemplate;
    }

    public function getIdentityVerificationRequestEmail($content, $data)
    {
        $date = now()->format('F j, Y');
        $emailTemplate = array();
        foreach ($content as $key => &$value) {
            $content[$key] = Str::replace('{userName}', $data['identityInfo']['name'], $value);
            $content[$key] = Str::replace('{userRole}', $data['identityInfo']['role'], $value);
            $content[$key] = Str::replace('{userEmail}', $data['identityInfo']['email'], $value);
            $content[$key] = Str::replace('{requestDate}', $date, $value);
        }
        $emailTemplate = $content;
        $emailTemplate['show_button'] = false;
        return $emailTemplate;
    }
    public function getIdentityVerificationApprovedEmail($content, $data)
    {
        $emailTemplate = array();
        foreach ($content as $key => &$value) {
            $content[$key] = Str::replace('{userName}', $data['name'], $value);
        }
        $emailTemplate = $content;
        $emailTemplate['show_button'] = false;
        return $emailTemplate;
    }

    public function getidentityVerificationRejectedEmail($content, $data)
    {
        $emailTemplate = array();
        foreach ($content as $key => &$value) {
            $content[$key] = Str::replace('{userName}', $data['name'], $value);
        }
        $emailTemplate = $content;
        $emailTemplate['show_button'] = false;
        return $emailTemplate;
    }

    public function getWithdrawWalletAmountRequestEmail($content, $data)
    {
        $emailTemplate = array();
        foreach ($content as $key => &$value) {
            $content[$key] = Str::replace('{userName}', $data['name'], $value);
            $content[$key] = Str::replace('{withdrawAmount}', '$' . $data['amount'], $value);
        }
        $emailTemplate = $content;
        $emailTemplate['show_button'] = false;
        return $emailTemplate;
    }


    public function getBookingRescheduledEmail($content, $data)
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
            $btnHtml = view('components.email.button', ['btnText' => trans('View Details'), 'btnUrl' => $data['viewLink']]);
            $emailTemplate['content']    = Str::replace("{viewLink}", $btnHtml, $emailTemplate['content']);
        }
        return $emailTemplate;
    }

    public function getBookingLinkGeneratedEmail($content, $data)
    {
        $emailTemplate = array();
        foreach ($content as $key => &$value) {
            $content[$key] = Str::replace('{tutorName}', $data['tutorName'] ?? '', $value);
            $content[$key] = Str::replace('{userName}', $data['userName'] ?? '', $value);
            $content[$key] = Str::replace('{sessionDate}', $data['sessionDate'] ?? '', $value);
            $content[$key] = Str::replace('{sessionSubject}', $data['sessionSubject'] ?? '', $value);
        }
        $emailTemplate = $content;
        if (Str::contains($emailTemplate['content'], '{meetingLink}')) {
            $btnHtml = view('components.email.button', ['btnText' => trans('calendar.join_session'), 'btnUrl' => $data['meetingLink']]);
            $emailTemplate['content']    = Str::replace("{meetingLink}", $btnHtml, $emailTemplate['content']);
        }
        return $emailTemplate;
    }

    public function getBookingCompletionRequestEmail($content, $data)
    {
        $emailTemplate = array();
        foreach ($content as $key => &$value) {
            $content[$key] = Str::replace('{tutorName}', $data['tutorName'] ?? '', $value);
            $content[$key] = Str::replace('{userName}', $data['userName'] ?? '', $value);
            $content[$key] = Str::replace('{sessionDateTime}', $data['sessionDateTime'] ?? '', $value);
            $content[$key] = Str::replace('{days}', $data['days'] ?? '', $value);
        }
        $emailTemplate = $content;
        if (Str::contains($emailTemplate['content'], '{completeBookingLink}')) {
            $btnHtml = view('components.email.button', ['btnText' => trans('calendar.btn_confirm_complete'), 'btnUrl' => $data['completeBookingLink']]);
            $emailTemplate['content']    = Str::replace("{completeBookingLink}", $btnHtml, $emailTemplate['content']);
        }
        return $emailTemplate;
    }

    public function getSessionBookingEmail($content, $data)
    {
        $emailTemplate = array();
        foreach ($content as $key => &$value) {
            $content[$key] = Str::replace('{tutorName}', $data['tutorName'] ?? '', $value);
            $content[$key] = Str::replace('{studentName}', $data['studentName'] ?? '', $value);
        }

        $emailTemplate = $content;

        if (Str::contains($emailTemplate['content'], '{bookingDetails}')) {
            $bookings = view('components.email.bookings', $data);
            $emailTemplate['content']    = Str::replace("{bookingDetails}", $bookings, $emailTemplate['content']);   
        }
        
        return $emailTemplate;
    }

    public function getSessionRequestEmail($content, $data)
    {
        $emailTemplate = array();
        foreach ($content as $key => &$value) {
            $content[$key] = Str::replace('{userName}', $data['userName'] ?? '', $value);
            $content[$key] = Str::replace('{studentName}', $data['studentName'] ?? '', $value);
            $content[$key] = Str::replace('{studentEmail}', $data['studentEmail'] ?? '', $value);
            $content[$key] = Str::replace('{sessionType}', $data['sessionType'] ?? '', $value);
            $content[$key] = Str::replace('{message}', $data['message'] ?? '', $value);
        }
        $emailTemplate = $content;
        return $emailTemplate;
    }

    public function getRenewSubscriptionEmail($content, $data)
    {
        $emailTemplate = array();
        foreach ($content as $key => &$value) {
            $content[$key] = Str::replace('{userName}', $data['userName'] ?? '', $value);
            $content[$key] = Str::replace('{subscriptionName}', $data['subscriptionName'] ?? '', $value);
            $content[$key] = Str::replace('{subscriptionExpiry}', $data['subscriptionExpiry'] ?? '', $value);
        }
        $emailTemplate = $content;
        if (Str::contains($emailTemplate['content'], '{renewalLink}')) {
            $btnHtml = view('components.email.button', ['btnText' => trans('subscriptions::subscription.renew_subscription_btn'), 'btnUrl' => $data['renewalLink']]);
            $emailTemplate['content']    = Str::replace("{renewalLink}", $btnHtml, $emailTemplate['content']);
        }
        return $emailTemplate;
    }

    public function getParentIdentityVerificationEmail($content, $data)
    {
        $emailTemplate = array();
        foreach ($content as $key => &$value) {
            $content[$key] = Str::replace('{{parent_name}}', $data['identityInfo']['parent_name'], $value);
            $content[$key] = Str::replace('{{user_details}}', $this->printUserIdentityDetails($data), $value);
        }
        $emailTemplate = $content;
        $emailTemplate['show_button'] = false;
        if (Str::contains($emailTemplate['content'], '{{approve_identity_link}}')) {
            $emailTemplate['content']    = Str::replace("{{approve_identity_link}}", '', $emailTemplate['content']);
            $emailTemplate['show_button'] = true;
            $emailTemplate['button_url'] = route('confirm-identity', $data['identityInfo']['user_id']);
            $emailTemplate['button_text'] = trans('identity.confirm_btn');
        }
        return $emailTemplate;
    }

    public function getParentIdentityConfirmationEmail($content, $data)
    {
        $emailTemplate = array();
        foreach ($content as $key => &$value) {
            $content[$key] = Str::replace('{{user_name}}', $data['user_name'], $value);
        }
        $emailTemplate = $content;
        $emailTemplate['show_button'] = false;
        if (Str::contains($emailTemplate['content'], '{{approve_profile_link}}')) {
            $emailTemplate['content']    = Str::replace("{{approve_profile_link}}", '', $emailTemplate['content']);
            $emailTemplate['show_button'] = true;
            $emailTemplate['button_url'] = route('admin.approve-user-identity', $data['user_id']);
            $emailTemplate['button_text'] = trans('identity.confirm_btn');
        }
        return $emailTemplate;
    }

    public function getAccountIdentityApprovedEmail($content, $data)
    {
        $emailTemplate = array();
        foreach ($content as $key => &$value) {
            $content[$key] = Str::replace('{{user_name}}', $data['user_name'], $value);
        }
        $emailTemplate = $content;
        $emailTemplate['show_button'] = false;
        return $emailTemplate;
    }

    public function getNewMessageEmail($content, $data)
    {
        $emailTemplate = array();
        foreach ($content as $key => &$value) {
            $content[$key] = Str::replace('{userName}', $data['userName'], $value);
            $content[$key] = Str::replace('{messageSender}', $data['messageSender'], $value);
        }
        $emailTemplate = $content;
        $emailTemplate['show_button'] = false;
        return $emailTemplate;
    }

    public function getAcceptedWithdrawRequestEmail($content, $data)
    {
        $emailTemplate = array();
        foreach ($content as $key => &$value) {
            $content[$key] = Str::replace('{userName}', $data['name'], $value);
            $content[$key] = Str::replace('{withdrawAmount}', $data['amount'], $value);
        }
        $emailTemplate = $content;
        $emailTemplate['show_button'] = false;
        return $emailTemplate;
    }

    public function getAccountIdentityRejectionEmail($content, $data)
    {
        $emailTemplate = array();
        foreach ($content as $key => &$value) {
            $content[$key] = Str::replace('{{user_name}}', $data['user_name'], $value);
            $content[$key] = Str::replace('{{admin_message}}', $data['message'], $value);
        }
        $emailTemplate = $content;
        $emailTemplate['show_button'] = false;
        return $emailTemplate;
    }

    public function getUserCreatedEmail($content, $data)
    {
        $emailTemplate = array();
        foreach ($content as $key => &$value) {
            $content[$key] = Str::replace('{{user_name}}', $data['user_name'], $value);
            $content[$key] = Str::replace('{{user_email}}', $data['user_email'], $value);
            $content[$key] = Str::replace('{{password}}', $data['user_password'], $value);
            $content[$key] = Str::replace('{{admin_name}}', $data['admin_name'], $value);
            $content[$key] = Str::replace('{{site_name}}', setting('site.name') ?? env('APP_NAME'), $value);
        }
        $emailTemplate = $content;
        $emailTemplate['show_button'] = false;
        return $emailTemplate;
    }

    public function getAccountApprovedEmail($content, $data)
    {
        $emailTemplate = array();
        foreach ($content as $key => &$value) {
            $content[$key] = Str::replace('{{user_name}}', $data['user_name'], $value);
        }
        $emailTemplate = $content;
        $emailTemplate['show_button'] = false;
        return $emailTemplate;
    }

    public function getInviteUserEmail($content, $data)
    {
        $emailTemplate = array();
        foreach ($content as $key => &$value) {
            $content[$key] = Str::replace('{userName}', $data['userName'], $value);
            $content[$key] = Str::replace('{forumTopicTitle}', $data['forumTopicTitle'], $value);
            $content[$key] = Str::replace('{message}', $data['message'], $value);
        }
        $emailTemplate = $content;
        if (Str::contains($emailTemplate['content'], '{inviteLink}')) {
            $btnHtml = view('components.email.button', ['btnText' => trans('email_template.btn_invite'), 'btnUrl' => $data['inviteLink']]);
            $emailTemplate['content']  = Str::replace("{inviteLink}", $btnHtml, $emailTemplate['content']);
        }
        return $emailTemplate;
    }
    public function getDisputeReasonEmail($content, $data) {
        $emailTemplate = array();
        foreach ($content as $key => &$value) {
            $content[$key] = Str::replace('{studentName}', $data['studentName'], $value);
            $content[$key] = Str::replace('{tutorName}', $data['tutorName'], $value);
            $content[$key] = Str::replace('{sessionDateTime}', \Carbon\Carbon::parse($data['sessionDateTime'])->format('F j, Y, g:i A'), $value);
            $content[$key] = Str::replace('{disputeReason}', $data['disputeReason'], $value);
        }
        $emailTemplate = $content;
        return $emailTemplate;  
    }

    public function getDisputeResolutionEmail($content, $data) {
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

    public function getAssignedQuizEmail($content, $data){
       
        $emailTemplate = array();
        foreach ($content as $key => &$value) {
            $content[$key] = Str::replace('{studentName}', $data['studentName'], $value);
            $content[$key] = Str::replace('{tutorName}', $data['tutorName'], $value);
            $content[$key] = Str::replace('{quizName}', $data['quizTitle'], $value);
        }
        $emailTemplate = $content;
        $attempQuizUrl = $data['quizUrl'];

        $btnHtml = view('components.email.button', ['btnText' => 'Attempt Quiz', 'btnUrl' => $attempQuizUrl])->render();
        $emailTemplate['content'] = Str::replace('{attempt_quiz_link}', $btnHtml, $emailTemplate['content']);
        return $emailTemplate;
    }

    public function getReviewedQuizEmail($content, $data){
        $emailTemplate = array();
        foreach ($content as $key => &$value) {
            $content[$key] = Str::replace('{studentName}', $data['studentName'], $value);
            $content[$key] = Str::replace('{tutorName}', $data['tutorName'], $value);
            $content[$key] = Str::replace('{quizName}', $data['quizTitle'], $value);
        }
        $emailTemplate = $content;
        return $emailTemplate;
    }

    public function getGenerateQuizResultEmail($content, $data){
        $emailTemplate = array();
        foreach ($content as $key => &$value) {
            $content[$key] = Str::replace('{studentName}', $data['studentName'], $value);
            $content[$key] = Str::replace('{tutorName}', $data['tutorName'], $value);
            $content[$key] = Str::replace('{quizName}', $data['quizTitle'], $value);
        }
        $emailTemplate = $content;
        $attempQuizUrl = $data['quizUrl'];

        $btnHtml = view('components.email.button', ['btnText' => 'View Result', 'btnUrl' => $attempQuizUrl])->render();
        $emailTemplate['content'] = Str::replace('{quiz_result_link}', $btnHtml, $emailTemplate['content']);
        return $emailTemplate;
    }

    public function printUserIdentityDetails($identityInfo) {
        $info = '<br />';
        $info .= '<b>' . trans('identity.name') . '</b> :' . Str::ucfirst($identityInfo['identityInfo']['name']) . "<br>";
        // $info .= '<b>' . trans('identity.phone') . '</b> :' . $identityInfo['phone'] . "<br>";
        if (!empty($identityInfo['identityInfo']['email']))
            $info .= '<b>' . trans('identity.email') . '</b> :' . $identityInfo['identityInfo']['email'] . "<br>";
        if (!empty($identityInfo['identityInfo']['gender']))
            $info .= '<b>' . trans('identity.gender') . '</b> :' . Str::ucfirst($identityInfo['identityInfo']['gender']) . "<br>";
        if (!empty($identityInfo['identityInfo']['school_name']))
            $info .= '<b>' . trans('identity.school') . '</b> :' . $identityInfo['identityInfo']['school_name'] . "<br>";
        if (!empty($identityInfo['identityInfo']['parent_name']))
            $info .= '<b>' . trans('identity.parent_name') . '</b> :' . Str::ucfirst($identityInfo['identityInfo']['parent_name']) . "<br>";
        if (!empty($identityInfo['identityInfo']['parent_email']))
            $info .= '<b>' . trans('identity.parent_email') . '</b> :' . $identityInfo['identityInfo']['parent_email'] . "<br>";
        if (!empty($identityInfo['identityInfo']['parent_phone']))
            $info .= '<b>' . trans('identity.parent_phone') . '</b> :' . $identityInfo['identityInfo']['parent_phone'] . "<br>";
        if ($identityInfo['identityInfo']['personal_photo'])
            $info .= '<b>' . trans('identity.other_info') . '</b> <br /><img src="' . url(Storage::url($identityInfo['identityInfo']['personal_photo'])) . '"/> <br>';
        if ($identityInfo['identityInfo']['attachments'])
            $info .= '<b>' . trans('identity.other_attachment') . '</b> <br /><img src="' . url(Storage::url($identityInfo['identityInfo']['attachments'])) . '"/> <br>';
        if ($identityInfo['identityInfo']['transcript'])
            $info .= '<b>' . trans('identity.transcript') . '</b> <br /><img src="' . url(Storage::url($identityInfo['identityInfo']['transcript'])) . '"/> <br>';
        return $info;
    }

    public function getcourseApprovedEmail($content, $data)
    {
        $emailTemplate = array();
        foreach ($content as $key => &$value) {
            $content[$key] = Str::replace('{courseTitle}', $data['courseTitle'], $value);
            $content[$key] = Str::replace('{userName}', $data['userName'], $value);
        }
        $emailTemplate = $content;

        return $emailTemplate;
    }
    public function getcourseRejectedEmail($content, $data)
    {
        $emailTemplate = array();
        foreach ($content as $key => &$value) {
            $content[$key] = Str::replace('{courseTitle}', $data['courseTitle'], $value);
            $content[$key] = Str::replace('{userName}', $data['userName'], $value);
        }
        $emailTemplate = $content;
        return $emailTemplate;
    }

    public function getAssignedAssignmentEmail($content, $data){
       
        $emailTemplate = array();
        foreach ($content as $key => &$value) {
            $content[$key] = Str::replace('{studentName}', $data['studentName'], $value);
            $content[$key] = Str::replace('{tutorName}', $data['tutorName'], $value);
            $content[$key] = Str::replace('{assignmentName}', $data['assignmentTitle'], $value);
        }
        $emailTemplate = $content;
        $attempAssignmentUrl = $data['assignedAssignmentUrl'];

        $btnHtml = view('components.email.button', ['btnText' => 'Assign Assignment', 'btnUrl' => $attempAssignmentUrl])->render();
        $emailTemplate['content'] = Str::replace('{attempt_assignment_link}', $btnHtml, $emailTemplate['content']);
        return $emailTemplate;
    }

    public function getReviewedAssignmentEmail($content, $data){
        $emailTemplate = array();
        foreach ($content as $key => &$value) {
            $content[$key] = Str::replace('{studentName}', $data['studentName'], $value);
            $content[$key] = Str::replace('{tutorName}', $data['tutorName'], $value);
            $content[$key] = Str::replace('{assignmentName}', $data['assignmentTitle'], $value);
        }
        $emailTemplate = $content;
        return $emailTemplate;
    }

    public function getGenerateAssignmentResultEmail($content, $data){
        $emailTemplate = array();
        foreach ($content as $key => &$value) {
            $content[$key] = Str::replace('{studentName}', $data['studentName'], $value);
            $content[$key] = Str::replace('{tutorName}', $data['tutorName'], $value);
            $content[$key] = Str::replace('{assignmentName}', $data['assignmentTitle'], $value);
        }
        $emailTemplate = $content;
        $attempAssignmentUrl = $data['assignmentResultUrl'];

        $btnHtml = view('components.email.button', ['btnText' => 'View Result', 'btnUrl' => $attempAssignmentUrl])->render();
        $emailTemplate['content'] = Str::replace('{assignment_result_link}', $btnHtml, $emailTemplate['content']);
        return $emailTemplate;
    }
}
