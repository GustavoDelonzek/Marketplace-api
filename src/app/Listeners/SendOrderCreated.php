<?php

namespace App\Listeners;

use App\Events\OrderCreated ;
use App\Notifications\OrderCreatedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendOrderCreated
{
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
    public function handle(OrderCreated  $event): void
    {
        $event->user->notify(
            new OrderCreatedNotification($event->user, $event->order)
        );
    }
}
