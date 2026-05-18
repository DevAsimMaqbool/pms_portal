<?php

namespace App\Services;

use App\Models\User;
use App\Notifications\WorkflowNotification;

class NotificationService
{
    public static function send(
        $users,
        string $title,
        string $message,
        string $module,
        int $recordId
    ) {

        if (!$users) {
            return;
        }

        if (!is_iterable($users)) {
            $users = [$users];
        }

        foreach ($users as $user) {

            if (!$user) {
                continue;
            }

            $user->notify(
                new WorkflowNotification([

                    'title' => $title,

                    'message' => $message,

                    'module' => $module,

                    'record_id' => $recordId,

                    'url' => url("/research-publications/{$recordId}")
                ])
            );
        }
    }
}