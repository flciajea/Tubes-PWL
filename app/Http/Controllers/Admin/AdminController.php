<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Event;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalUsers = User::count();
        $totalEvents = Event::count();

        $latestEvents = Event::latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalEvents',
            'latestEvents'
        ));
    }
}