<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Games;
use App\Models\GameType;
use Illuminate\Support\Facades\Auth;

class GameController extends Controller
{
    public function dashboard(Request $request)
    {
        $user = auth()->user();

        // Admins direct naar admin dashboard
        if ($user && ($user->role_id == 1 || $user->role?->name === 'admin')) {
            return redirect()->route('admin.dashboard');
        }

        // Normaal gebruikersdashboard — alleen zichtbare games
        $query = Games::query()
            ->with(['user', 'gameType'])
            ->where('is_visible', true);

        // Zoekfunctie
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Filter op type
        if ($request->filled('game_type')) {
            $query->where('game_type_id', $request->input('game_type'));
        }

        // Filter op aantal spelers
        if ($request->filled('players')) {
            $query->where('total_players', '>=', $request->input('players'));
        }

        $games = $query->get();
        $gameTypes = GameType::all();

        return view('dashboard', compact('games', 'gameTypes'));
    }

    public function show(Games $game)
    {
        // Alleen admin mag verborgen games bekijken
        if (!$game->is_visible && (!auth()->check() || auth()->user()->role_id != 1)) {
            abort(403, 'This game is not available to see');
        }

        return view('games.show', compact('game'));
    }

    public function create()
    {
        $gameTypes = GameType::all();
        return view('games.create', compact('gameTypes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|unique:games|max:255',
            'description' => 'required',
            'total_players' => 'required|integer|min:1',
            'game_type_id' => 'required|integer|exists:game_types,id',
        ]);

        $validated['user_id'] = Auth::id();
        // standaard zichtbaar bij aanmaken
        $validated['is_visible'] = true;

        Games::create($validated);

        // Redirect afhankelijk van rol
        if (Auth::user()->role_id == 1) {
            return redirect()->route('admin.dashboard')
                ->with('Added a new game!');
        }

        return redirect()->route('dashboard')
            ->with('Added a new game!');
    }

    public function edit(Games $game)
    {
        $gameTypes = GameType::all();

        return view('games.edit', [
            'game' => $game,
            'gameTypes' => $gameTypes,
        ]);
    }

    public function update(Request $request, Games $game)
    {
        $validated = $request->validate([
            'name' => 'required|max:255|unique:games,name,' . $game->id,
            'description' => 'required',
            'total_players' => 'required|integer|min:1',
            'game_type_id' => 'required|integer|exists:game_types,id',
        ]);

        $game->update($validated);

        return redirect()->route('dashboard')
            ->with('success', 'Game updated!');
    }

    public function destroy(Games $game)
    {
        $user = auth()->user();

        if (!$user) {
            abort(403, 'You must be logged in to perform this action.');
        }

        // Admins mogen altijd verwijderen
        if ($user->isAdmin()) {
            $game->delete();
            return redirect()->route('dashboard')
                ->with('success', 'Game deleted successfully!');
        }

        // Alleen eigen games verwijderen
        if ($user->id !== $game->user_id) {
            abort(403, 'You can only delete your own game.');
        }

        // Extra validatie: minstens 3 games
        $gameCount = Games::where('user_id', $user->id)->count();
        if ($gameCount < 3) {
            return back()->withErrors('You must have added at least 3 games before you can delete one.');
        }

        $game->delete();

        return redirect()->route('dashboard')
            ->with('Game deleted successfully!');
    }
}
