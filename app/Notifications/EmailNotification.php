<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class EmailNotification extends Notification //implements ShouldQueue
{
    use Queueable;

    public $template;
    public $emailSetting;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($template) {
        $this->template = $template;
        $this->emailSetting = setting('_email');
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable) {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable) {
        $mail = (new MailMessage);

        if (!empty($this->emailSetting['sender_email']) && !empty($this->emailSetting['sender_name']))
            $mail->from($this->emailSetting['sender_email'], $this->emailSetting['sender_name']);

        if (!empty($this->template['subject']))
            $mail->subject($this->template['subject']);

        return  $mail->view('emails.template', [
            'greeting'      => $this->template['greeting'],
            'content'       => $this->template['content'],
            'signature'     => $this->emailSetting['sender_signature'] ?? '',
            'copyright'     => $this->emailSetting['footer_text'] ?? '',
        ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable) {
        return [
            //
        ];
    }
}
