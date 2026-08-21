<?php

namespace App\Http\Controllers;

use App\Models\NewGoal;
use Illuminate\Support\Facades\Auth;

class GoalHistoryController extends Controller
{
    public function index(NewGoal $newgoal)
    {
        /*
         * Employee
         */
        $isOwner =
            $newgoal->user_id == Auth::id();

        /*
         * Manager
         */
        $isManager =
            $newgoal->user &&
            $newgoal->user->manager_id == Auth::id();

        /*
         * HR
         *
         * Replace this with your actual PMS HR
         * role/permission if required.
         */
        $isHr =
            Auth::user()->hasRole('HR');

        abort_unless(
            $isOwner ||
            $isManager ||
            $isHr,
            403
        );

        $newgoal->load([
            'user',
            's2rDriver',
            'selfReports.reviews.reviewer',
            'histories.user',
        ]);

        $histories = $newgoal->histories()
            ->with('user')
            ->latest()
            ->get();

        return view(
            'admin.new_goals.history',
            compact(
                'newgoal',
                'histories'
            )
        );
    }
}