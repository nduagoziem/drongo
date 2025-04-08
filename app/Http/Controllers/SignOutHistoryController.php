<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\SignOutHistory;
use Illuminate\Support\Facades\Auth;

class SignOutHistoryController extends Controller
{
    public function create(Request $request, SignOutHistory $signOutHistory)
    {
        $date = $request->input('date');
        $user_id = Auth::id(); // Get the current user's ID

        $data = collect(); // Initialize as empty collection

        if ($date) {
            $data = $signOutHistory->select(["full_name", "time", "role", "remark"])
                ->where("user_id", $user_id)
                ->where('created_at', 'like', $date . '%')
                ->get();
        }

        return Inertia::render('Admin/SignOutHistory', [
            'signoutHistory' => $data
        ]);
    }

}
