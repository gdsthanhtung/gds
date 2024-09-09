<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class LogRemovePhongTroRecord implements ShouldQueue
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
        Log::info("PhongTro record has been removed: ", [
            'route' => json_encode($this->params)
        ]);
        $this->subFunction();
    }

    public function subFunction()
    {
        Log::build([
            'driver' => 'single',
            'path' => storage_path('logs/custom.log'),
            ])->warning("PhongTro record has been removed: ", [
                'route' => json_encode($this->params)
            ]);
    }

    public function failed()
    {

    }
}
