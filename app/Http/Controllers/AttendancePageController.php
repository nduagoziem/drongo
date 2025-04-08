<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use Inertia\Inertia;
use Inertia\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;
use App\Models\SignInHistory;
use App\Models\SignOutHistory;
use App\Services\FacePPAPIService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class AttendancePageController extends Controller
{
    public function create($user_uid)
    {
        if (Cache::get("attendance_page_closed_{$user_uid}", false)) {
            abort(403, 'Attendance page closed');
        }

        $user = User::where('user_uid', $user_uid)->firstOrFail();

        return Inertia::render('AttendancePage', [
            'user' => $user
        ]);
    }

    public function open($user_uid)
    {
        Cache::forget("attendance_page_closed_{$user_uid}");
    }

    public function close($user_uid)
    {
        Cache::forever("attendance_page_closed_{$user_uid}", true);
    }

    public function lateMarkingTime($user_uid, Request $request)
    {
        // Avoiding PDO Serialization Error
        $value = json_encode([
            "time" => $request->input('inputTime')
        ]);

        Cache::put("late_marking_time_{$user_uid}", $value, now()->endOfDay());
    }

    public function signInAttendance(Request $request, $user_uid)
    {
        try {
            // Captured image from attendance page
            $capturedImage = $request->input("employee_image"); // Image is in base64 format

            $signInTime = $request->input("signInTime");

            // Get the late status time from the cache
            $lateStatusTime = Cache::get("late_marking_time_{$user_uid}");
            if ($lateStatusTime) {
                $lateStatusTime = json_decode($lateStatusTime, true)['time'];
            } else {
                return response()->json(["failure" => "Server Error. Try again"]);
            }

            $signInTime = Carbon::parse($signInTime);
            $lateStatusTime = Carbon::parse($lateStatusTime);

            $user = User::where("user_uid", $user_uid)->first();

            $employees = Employee::select("employee_image", "full_name", "role")
                ->whereBelongsTo($user)
                ->get();

            $facePPAPIService = new FacePPAPIService();


            foreach ($employees as $employee) {
                $referenceImage = base64_encode(Storage::disk("local")->get($employee->employee_image));
                $comparisonResult = $facePPAPIService->compareImageByBase64($capturedImage, $referenceImage);

                if (isset($comparisonResult['confidence']) && $comparisonResult['confidence'] >= 90) {

                    $remark = $signInTime->lessThan($lateStatusTime) ? "Early" : "Late";

                    SignInHistory::create([
                        "user_id"   => $user->id,
                        "full_name" => $employee->full_name,
                        "time"      => $signInTime->toTimeString(),
                        "role"      => $employee->role,
                        "remark"    => $remark,
                    ]);

                    return response()->json([
                        "success"  => "{$employee->full_name} - {$employee->role}",
                        "remark" => "You Clocked In - {$remark}",
                    ]);
                }
            }
            return response()->json(["failure" => "Your credentials do not match our records"]);
        } catch (\Exception $e) {
            return response()->json(["failure" => "Check your internet connection and try again"]);
        }
    }

    public function signOutAttendance(Request $request, $user_uid)
    {
        try {
            // Captured image from attendance page
            $capturedImage = $request->input("employee_image"); // Image is in base64 format

            $signOutTime = $request->input("signOutTime");

            $signOutTime = Carbon::parse($signOutTime);

            $user = User::where("user_uid", $user_uid)->first();

            $employees = Employee::select("employee_image", "full_name", "role")
                ->whereBelongsTo($user)
                ->get();

            // Instantiate the FacePPAPIService
            $facePPAPIService = new FacePPAPIService();

            foreach ($employees as $employee) {
                $referenceImage = base64_encode(Storage::disk("local")->get($employee->employee_image));
                $comparisonResult = $facePPAPIService->compareImageByBase64($capturedImage, $referenceImage);

                $fixedThreshold = 90;

                if (isset($comparisonResult['confidence']) && $comparisonResult['confidence'] >= $fixedThreshold) {

                    SignOutHistory::create([
                        "user_id"   => $user->id,
                        "full_name" => $employee->full_name,
                        "time"      => $signOutTime->toTimeString(),
                        "role"      => $employee->role,
                        "remark"    => "GoodBye"
                    ]);

                    return response()->json([
                        "success"  => "GoodBye - {$employee->full_name}",
                    ]);
                }
            }

            return response()->json(["failure" => "Your credentials do not match our records"]);
        } catch (\Exception $e) {
            return response()->json(["failure" => "Check your internet connection and try again"]);
        }
    }
}
