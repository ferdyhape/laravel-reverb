<?php

namespace App\Events;

use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserNotification implements ShouldBroadcast
{
    // ShouldBroadcastNow is used for instant notification
    // ShouldBroadcast is used for delayed notification
    use Dispatchable, SerializesModels;

    public $message;

    public function __construct($message)
    {
        $this->message = $message;
    }

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('user.' . $this->message['user_id']), // this channel setting related with route/channels.php
        ];
    }

    public function broadcastAs(): string
    {
        return 'user.notification'; // this event name setting related with the frontend where the event is listen
    }

    public function broadcastWith(): array
    {
        return [
            'id' => $this->message['id'],
            'title' => $this->message['title'],
            'body' => $this->message['body'],
            'created_at' => now()->toDateTimeString(),
        ];
    }
}
