<?php

namespace Modules\Courses\Jobs;

use App\Services\WalletService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class ClearCourseFundsJob implements ShouldQueue
{
    use Queueable;

    protected int $userId;
    protected float $coursePrice;
    protected $orderId;
    /**
     * Create a new job instance.
     */
    public function __construct(int $userId, float $coursePrice, $orderId = null)
    {
        $this->userId = $userId;
        $this->coursePrice = $coursePrice;
        $this->orderId = $orderId;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        (new WalletService())->makePendingFundsAvailable($this->userId, $this->coursePrice, $this->orderId);
    }
}
