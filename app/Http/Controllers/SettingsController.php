<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

class SettingsController extends Controller
{

    public function create()
    {
        $user = Auth::user(); // Get authenticated user

        return Inertia::render('Admin/Settings', [
            "user_uid" => $user->user_uid,
        ]);
    }
}
