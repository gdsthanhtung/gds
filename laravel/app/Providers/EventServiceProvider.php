<?php

namespace App\Providers;

use App\Events\CreatePhongTroEvent;
use App\Listeners\CreatePhongTroListener;
use App\Listeners\CreatePhongTroListenerSub;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Log;
use Throwable;

use function Illuminate\Events\queueable;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        Event::listen(
            CreatePhongTroEvent::class,
            CreatePhongTroListener::class
        );

        // Event::listen(queueable(function (CreatePhongTroEvent $event) {
        //     Log::info(now().' - Test event EventServiceProvider');
        // })->catch(function (CreatePhongTroEvent $event, Throwable $e) {
        //     Log::error(now().' - Test event EventServiceProvider');
        // }));
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
