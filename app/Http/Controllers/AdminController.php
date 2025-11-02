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

    public function toggleVisibility(Games $game)
    {
        $game->is_visible = !$game->is_visible;
        $game->save();

        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'visible' => $game->is_visible,
            ]);
        }

        return back()->with('status', 'Zichtbaarheid aangepast!');
    }
}
