<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class Export extends Notification
{
    use Queueable;

    public $export;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($export)
    {
        $this->export = $export;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        /* return [
            'type' => $this->export->type,
            'data' => $this->export->data,
        ]; */
        return $this->export;
    }
}
