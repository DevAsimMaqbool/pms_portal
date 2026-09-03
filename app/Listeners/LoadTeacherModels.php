<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Jobs\CalculateModals;
use Illuminate\Auth\Events\Login;
use App\Models\Year;

class LoadTeacherModels
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
    public function handle(Login $event): void
    {
        $activeRoleId = getRoleIdByName(activeRole());
        $activeRoleName=getRoleName(activeRole());
        $currentYear = SelectCurrentYear(1)->first();
        $user = $event->user;

        if ($currentYear) {
            CalculateModals::dispatch(
                $user->id,
                $activeRoleId,
                $currentYear->id,
                $activeRoleName
            )->onQueue('calculations');
        }
        
    }
}
