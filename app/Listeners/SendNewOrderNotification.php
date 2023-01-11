<?php

namespace App\Listeners;

use App\Events\OrderCreated;
use App\Mail\NewOrderMail;
use App\Models\User;
use App\Notifications\NewOrderNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Http\Request;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendNewOrderNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(OrderCreated $event)
    {
        $order = $event->order;

        $user = User::where('type', '=', 'admin')->first();

        // Send Notification
        $user->notify( new NewOrderNotification($order) );


        // Send e-mail message
        // Mail::to($user->email)->send( new NewOrderMail($order, $user) );
    }
}
