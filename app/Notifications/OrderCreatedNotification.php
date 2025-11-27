<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderCreatedNotification extends Notification
{
    use Queueable;

    public function __construct(private readonly Order $order)
    {
    }

    /**
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage())
            ->greeting('Dear '.$this->order->full_name.',')
            ->subject('New Order Received | Code '.$this->order->code)
            ->line('We are getting started on your order right away.')
            ->line('Your Order Code is '.$this->order->code)
            ->action('See Order Confirmation', $this->order->getCheckoutConfirmtionPath())
            ->line('Thank you for using our application!');
    }
}
