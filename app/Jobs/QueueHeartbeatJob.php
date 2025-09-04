<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Cache;

class QueueHeartbeatJob implements ShouldQueue
{

    public function handle()
    {
        Cache::put('queue_heartbeat_processed_at', now());
    }
}
