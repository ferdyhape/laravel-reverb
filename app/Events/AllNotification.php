<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AllNotification implements ShouldBroadcast
{
    use Dispatchable, SerializesModels;

    public $message;

    public function __construct($message)
    {
        $this->message = $message;
    }

    public function broadcastOn(): array
    {
        return [
            new Channel('public-messages'),
        ];
    }

    public function broadcastAs(): string
    {
        return 'all.notification';
    }

    public function broadcastWith(): array
    {
        return [
            'title' => $this->message['title'],
            'body' => $this->message['body'],
            'created_at' => now()->toDateTimeString(),
        ];
    }
}
