<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */

    protected $subscribe = [
        \App\Listeners\UserEventListener::class,
    ];

    protected $listen = [
        \App\Events\ArticleEvent::class => [
            \App\Listeners\ArticlesEventListener::class,
        ],
        \Illuminate\Auth\Events\Login::class => [
            \App\Listeners\UserEventListener::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

//        \Event::listen(
//           'article.created',
//            \App\Listeners\ArticlesEventListener::class
//
//          \App\Events\ArticleCreated::class,
//          \App\Listeners\ArticlesEventListener::class
//        );
    }
}
