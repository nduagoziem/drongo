<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class NewEmployeeController extends Controller {
    public function create() {
        return Inertia::render('Admin/NewEmployee');
    }
}
