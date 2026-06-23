<?php

namespace App\Jobs;

use App\Facades\DbNotification;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendDbNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public string $template;
    public User $recipient;
    public array $templateData;

    /**
     * Create a new job instance.
     */
    public function __construct(string $template, User $user, array $templateData)
    {
        $this->template     = $template;
        $this->recipient     = $user;
        $this->templateData = $templateData;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        DbNotification::dispatch($this->template, $this->recipient, $this->templateData);
    }
}
