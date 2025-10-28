<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController
{
    public function dashboard()
    {
        return view('admin.dashboard');
    }
}
