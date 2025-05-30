<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class BrowserNotifications
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;
    public $type; // Тип уведомления
    public $title; // Заголовок уведомления

    public function __construct($message, $type = 'info', $title = 'Уведомление')
    {
        \Log::info('Уведомление отправлено: ' . $message);
        $this->message = $message;
        $this->type = $type;
        $this->title = $title;
    }

    public function broadcastOn()
    {
        return new Channel('notifications');
    }
}
