<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GoalsAsignController extends Controller
{
    public function index()
    {
        return view('admin.goals_assign.index');
    }
}
