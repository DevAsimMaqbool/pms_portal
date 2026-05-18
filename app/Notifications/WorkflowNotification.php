<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class WorkflowNotification extends Notification
{
    use Queueable;

    public function __construct(
        public array $data
    ) {
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [

            'module' => $this->data['module'] ?? null,

            'record_id' => $this->data['record_id'] ?? null,

            'from_user_id' => $this->data['from_user_id'] ?? null,

            'for_user_id' => $this->data['for_user_id'] ?? null,

            'title' => $this->data['title'] ?? null,

            'message' => $this->data['message'] ?? null,

            'action_url' => $this->data['action_url'] ?? null,
        ];
    }
}