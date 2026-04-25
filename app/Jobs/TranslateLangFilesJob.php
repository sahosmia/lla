<?php

namespace App\Jobs;

use App\Services\TranslationService;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Cache;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class TranslateLangFilesJob implements ShouldQueue
{
    use Dispatchable, Queueable;

    protected $files;
    protected $lang;
    protected $jobId;

    public function __construct($files, $lang, $jobId)
    {
        $this->files = $files;
        $this->lang = $lang;
        $this->jobId = $jobId;
    }

    public function handle()
    {
        $service = new TranslationService();
        $total = count($this->files);

        foreach ($this->files as $index => $file) {
            $service->translateFileHandler($file, $this->lang);

            $progress = intval((($index + 1) / $total) * 100);
            Cache::put("translate_progress_{$this->jobId}", $progress, 600);
        }

        Cache::put("translate_done_{$this->jobId}", true, 600);
    }
}
