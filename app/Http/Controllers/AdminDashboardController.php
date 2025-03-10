<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Employee;
use App\Models\SignInHistory;
use App\Models\SignOutHistory;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class AdminDashboardController extends Controller
{

    public function create()
    {

        $user_id = Auth::id();

        $created_at = Carbon::today()->toDateString();

        return Inertia::render('Admin/AdminDashboard', [
            "number_of_employees" => Employee::select("full_name")->where("user_id", "{$user_id}")->count(),
            "signed_in_employees" => SignInHistory::select("full_name")->where("user_id", "{$user_id}")->whereDate("created_at", $created_at)->count(),
            "signed_out_employees" => SignOutHistory::select("full_name")->where("user_id", "{$user_id}")->whereDate("created_at", $created_at)->count(),
        ]);
    }
}
