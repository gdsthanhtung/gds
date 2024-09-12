<?php

namespace App\Listeners;

use App\Events\CreatePhongTroEvent;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class CreatePhongTroListener implements ShouldQueue
{
    //use Queueable;
    public $queue = 'eventListenerPhongtro';
    public $delay = 10;

    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(CreatePhongTroEvent $event): void
    {
        Log::info(now().' - Test event listener CreatePhongTroListener | ', ['data' => $event->data]);
    }

    public function failed(CreatePhongTroEvent $event, $exc){
        //To-do...
    }
}
