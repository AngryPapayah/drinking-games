<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        if (!auth()->check() || auth()->user()->role_id !== 1) {
            abort(403, 'Unauthorized access');
        }

        return view('admin.dashboard');
    }
}
