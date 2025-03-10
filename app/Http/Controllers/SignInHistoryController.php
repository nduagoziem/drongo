<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\SignInHistory;
use Illuminate\Support\Facades\Auth;

class SignInHistoryController extends Controller
{
    public function create(Request $request, SignInHistory $signInHistory)
    {
        $date = $request->input('date');
        $user_id = Auth::id();

        $data = collect(); // Initialize as empty collection

        if ($date) {
            $data = $signInHistory->select(["full_name", "time", "role", "remark", "created_at"])
                ->where("user_id", $user_id)
                ->where('created_at', 'like', $date . '%')
                ->get();
        }

        return Inertia::render('Admin/SignInHistory', [
            'signinHistory' => $data
        ]);
    }
}
