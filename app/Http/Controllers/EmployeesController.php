<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class EmployeesController extends Controller
{
    // Employee Component rendering
    public function create(Request $request)
    {
        // Search Input
        $search = $request->input('search');

        $user_id = Auth::id(); // Get the current user's ID

        $employees = Employee::select(['employee_uid', 'full_name', 'role'])
            ->where('user_id', $user_id) // Filter by the current user's ID
            ->when($search, function ($query, $search) {
                return $query->where('full_name', 'like', "%{$search}%");
            })->get();

        return Inertia::render('Admin/Employees', [
            'employees' => $employees,
        ]);
    }

    // Creating An Employee in the database
    public function store(Request $request)
    {
        $request->validate([
            'employee_image' => 'required|string',
            'full_name' => 'required|string|max:255',
            'role' => 'required|string',
        ]);

        $user_id = Auth::id();

        /**
         * Temporary Image path
         * This is to avoid a null constraint issue in the database
         */
        $tempImagePath = "employees_img/default.png";

        // First, create the employee to get the ID
        $employee = Employee::create([
            'full_name' => $request->input('full_name'),
            'role' => $request->input('role'),
            'employee_image' => $tempImagePath, // Set temporary path
            'user_id' => $user_id, // Include user_id
        ]);

        // Decode the image from base64
        $imageData = $request->input('employee_image');
        $image = str_replace('data:image/png;base64,', '', $imageData);
        $image = str_replace(' ', '+', $image);

        // Use employee ID in the image name
        $imageName = "employee_{$employee->employee_uid}.png";

        /**
         * Store the image
         * Default storage is storage/app/private
         * This can be changed in filesystems.php config
         */
        Storage::put("employees_img/{$imageName}", base64_decode($image));
        
        // Update the employee record with the actual image path
        $employee->update([
            'employee_image' => "employees_img/{$imageName}",
        ]);

        return redirect()->route('employees.create');
    }

    // Deleting An Employee
    public function destroy($employee_uid)
    {
        $user_id = Auth::id();

        $employee = Employee::where('employee_uid', $employee_uid)->where('user_id', $user_id)->firstOrFail();

        Storage::delete($employee->employee_image);

        $employee->delete();

        return redirect()->route('employees.create');
    }

    // Editing An Employee
    public function showEdit($employee_uid)
    {
        $user_id = Auth::id();

        $employee = Employee::where('employee_uid', $employee_uid)->where('user_id', $user_id)->firstOrFail();

        if ($employee->user_id !== $user_id) {
            abort(403, 'Unauthorized action.');
        }

        return Inertia::render('Admin/EditEmployee', [
            "employee" => $employee
        ]);
    }


    public function update(Request $request, $employee_uid)
    {
        $user_id = Auth::id();

        $employee = Employee::where('employee_uid', $employee_uid)->where('user_id', $user_id)->firstOrFail();

        $request->validate([
            'employee_image' => 'required|string',
            'full_name' => 'required|string|max:255',
            'role' => 'required|string|max:255',
        ]);

        // If the image is not a base64 string, assume it's an existing image URL
        if (!str_starts_with($request->employee_image, 'data:image')) {
            $imagePath = $request->employee_image; // Keep existing image
        } else {
            // Delete old image if exists
            if ($employee->employee_image && Storage::exists($employee->employee_image)) {
                Storage::delete($employee->employee_image);
            }

            // Decode and save new image
            $imageData = str_replace('data:image/png;base64,', '', $request->employee_image);
            $imageData = str_replace(' ', '+', $imageData);
            $imageName = "employee_{$employee->employee_uid}.png";

            Storage::put("employees_img/{$imageName}", base64_decode($imageData));

            // Update the image path
            $imagePath = "employees_img/{$imageName}";
        }

        $employee->update([
            'full_name' => $request->full_name,
            'role' => $request->role,
            'employee_image' => $imagePath, // Ensures image is always updated
        ]);

        return redirect()->route("employees.create");

        /** Footnotes
         * An image must be sent even if employees do not update their images
         * If an employee's image is not updated, the existing one will be sent back and reused
         * This is to avoid image not found issues
         */
    }
}
