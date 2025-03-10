<?php

namespace App\Http\Controllers;

use App\Models\SignInHistory;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AttendanceRankingController extends Controller
{
    public function create()
    {
        $today = Carbon::today();
        $lastDayOfMonth = $today->copy()->endOfMonth();

        if (!$today->isSameDay($lastDayOfMonth)) {
            return Inertia::render('Admin/AttendanceRanking', [
                "earlyRanking" => [],
                "lateRanking" => [],
                "message" => "Rankings are only available on the last day of each month."
            ]);
        }

        $user_id = Auth::id();

        $earlyRanking = SignInHistory::where('remark', 'Early')
            ->where('user_id', $user_id)
            ->whereMonth('created_at', $today->month)
            ->whereYear('created_at', $today->year)
            ->selectRaw('user_id, full_name, role, COUNT(*) as early_count')
            ->groupBy(['user_id', 'full_name', 'role'])
            ->orderByDesc('early_count')
            ->take(10)
            ->get()
            ->map(function ($entry) {
                return [
                    'user_id' => $entry->user_id,
                    'full_name' => $entry->full_name,
                    'role' => $entry->role
                ];
            });

        $lateRanking = SignInHistory::where('remark', 'Late')
            ->where('user_id', $user_id)
            ->whereMonth('created_at', $today->month)
            ->whereYear('created_at', $today->year)
            ->selectRaw('user_id, full_name, role, COUNT(*) as late_count')
            ->groupBy(['user_id', 'full_name', 'role'])
            ->orderByDesc('late_count')
            ->take(10)
            ->get()
            ->map(function ($entry) {
                return [
                    'user_id' => $entry->user_id,
                    'full_name' => $entry->full_name,
                    'role' => $entry->role
                ];
            });

        return Inertia::render('Admin/AttendanceRanking', [
            "earlyRanking" => $earlyRanking,
            "lateRanking" => $lateRanking,
        ]);
    }
}
