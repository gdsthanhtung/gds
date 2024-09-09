<?php

namespace App\Jobs;

use App\Http\Controllers\Admin\CongDanController;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SendReminderDKTTEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $params;
    public $tries = 3;
    public $timeout = 30;
    /**
     * Create a new job instance.
     */
    public function __construct($params)
    {
        $this->params = $params;
        $this->queue = 'dktt';
        $this->delay = now()->addSeconds(10);
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $congDanController = (new CongDanController);
        $rs = $congDanController->sendmail(/*$params*/);

        Log::build([
            'driver' => 'single',
            'path' => storage_path('logs/reminderDKTT.log'),
            ])->info("ReminderDKTT has been executed: ", [
                'data' => json_encode($rs)
            ]);
    }
}
