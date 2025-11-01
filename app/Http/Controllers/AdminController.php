<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Games;

class AdminController extends Controller
{
    public function dashboard()
    {
        $games = Games::with(['gameType', 'user'])->get();

        return view('admin.dashboard', [
            'user' => Auth::user(),
            'games' => $games,
        ]);
    }
}
