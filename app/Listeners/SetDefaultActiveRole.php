<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Auth\Events\Login;
class SetDefaultActiveRole
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        $role = $event->user->roles->first()?->name;

        $teacherRoles = [
            'Teacher',
            'Assistant Professor',
            'Associate Professor',
            'Professor',
            'Program Leader UG',
            'Program Leader PG'
        ];

        if (in_array($role, $teacherRoles)) {
            session(['active_role' => 'teacher']);
        } elseif ($role) {
            session(['active_role' => strtolower($role)]);
        }
    }
}
