<?php

namespace App\Events;

use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class RealtimeNotification implements ShouldBroadcast
{
    public $data;

    public $userId;

    public function __construct($data, $userId)
    {
        $this->data = $data;

        $this->userId = $userId;
    }

    public function broadcastOn()
    {
        return new PrivateChannel(
            'notifications.' . $this->userId
        );
    }

    public function broadcastAs()
    {
        return 'new.notification';
    }
}