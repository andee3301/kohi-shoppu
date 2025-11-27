<?php

namespace App\Providers;

use App\Events\OrderCreated;
use App\Listeners\OrderCreatedListener;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        OrderCreated::class => [
            OrderCreatedListener::class,
        ],
    ];
}
