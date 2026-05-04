<?php

namespace App\Providers;

use App\Events\Contacts\ContactCreatedEvent;
use App\Events\Contacts\ContactDeletedEvent;
use App\Events\Contacts\ContactUpdatedEvent;
use App\Listeners\DeleteContactInCRMListener;
use App\Listeners\UpdateContactInCRMListener;
use App\Listeners\SendContactToCRMListener;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

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

        ContactCreatedEvent::class => [
            SendContactToCRMListener::class,
        ],

        ContactUpdatedEvent::class => [
            UpdateContactInCRMListener::class,
        ],

        ContactDeletedEvent::class => [
            DeleteContactInCRMListener::class,
        ]
    ];

    /**
     * Register any events for your application.
     */
    #[\Override] public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
