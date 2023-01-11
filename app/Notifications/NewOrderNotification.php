<?php

namespace App\Notifications;

use App\Helpers\Money;
use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\DatabaseMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Twilio\TwilioChannel;
use NotificationChannels\Twilio\TwilioSmsMessage;
use Illuminate\Notifications\Messages\VonageMessage;

class NewOrderNotification extends Notification
{
    use Queueable;

    protected Order $order;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Get the notification's delivery channels.
     * database, mail, broadcast (real-time notification), vonage (SMS), slack
     * custom: ...
     *
     * @param  mixed  $notifiable User who will receive the notification
     * @return array
     */
    public function via($notifiable)
    {
        if ($notifiable->prefer_sms) {
            return ['vonage'];
        }
        return [
            'mail', 
            'database', 
            'broadcast',
            'vonage',
            //TwilioChannel::class,
        ];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('New Order #' . $this->order->id)
                    ->from('notifications@localhost')
                    ->greeting('Hello ' . $notifiable->name)
                    ->line("A new order #{$this->order->id} has been placed in the store.")
                    ->line("The total amount of this order is: " . Money::format($this->order->total))
                    ->action('View Order', url('/dashboard'))
                    ->line('Thank you for using our application!');
                    //->view('', []);
    }

    public function toDatabase($notifiable)
    {
        return new DatabaseMessage([
            'title' => 'New Order #' . $this->order->id,
            'body'  => 'A new order has created.',
            'icon'  => '<i class="fas fa-envelope mr-2"></i>',
            'link'  => url('/dashboard'),
        ]);
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'title' => 'New Order #' . $this->order->id,
            'body'  => 'A new order has created.',
            'icon'  => '<i class="fas fa-envelope mr-2"></i>',
            'link'  => url('/dashboard'),
        ]);
    }

    public function toTwilio($notifiable)
    {
        return (new TwilioSmsMessage())
            ->content("New Order #' . {$this->order->id}");
    }

    public function toVonage($notifiable)
    {
        return (new VonageMessage())
            ->content("New Order #' . {$this->order->id}");
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
