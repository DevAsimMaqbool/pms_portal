<?php

namespace App\Services;

use App\Notifications\WorkflowNotification;
use App\Events\RealtimeNotification;

class WorkflowService
{
    public static function notify(

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

            $data = [

                'title' => $title,

                'message' => $message,

                'module' => $module,

                'record_id' => $recordId,

                'action_url' => url("/{$module}/{$recordId}")
            ];

            /*
            |--------------------------------------------------------------------------
            | Store Notification
            |--------------------------------------------------------------------------
            */

            $user->notify(
                new WorkflowNotification($data)
            );

            /*
            |--------------------------------------------------------------------------
            | Broadcast Realtime Event
            |--------------------------------------------------------------------------
            */

            event(
                new RealtimeNotification(
                    $data,
                    $user->id
                )
            );
        }
    }
}