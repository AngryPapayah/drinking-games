<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Games;
use App\Models\GameType;
use Illuminate\Support\Facades\Auth;

class GameController extends Controller
{
    public function index()
    {
        $games = Games::all();
        return view('games.index', compact('games'));
    }

    public function dashboard(Request $request)
    {
        $user = auth()->user();

        // ✅ Als de ingelogde gebruiker admin is → direct doorsturen
        // Pas dit aan op basis van jouw setup:
        // - gebruik role_id (bijv. 2 = admin)
        // - of role->name === 'admin' als je een relatie gebruikt
        if ($user && ($user->role_id == 1 || $user->role?->name === 'admin')) {
            return redirect()->route('admin.dashboard');
        }

        // 🧩 Normaal gebruikersdashboard
        $query = Games::query()->with(['user', 'gameType']);

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($request->filled('game_type')) {
            $query->where('game_type_id', $request->input('game_type'));
        }

        if ($request->filled('players')) {
            $query->where('total_players', '>=', $request->input('players'));
        }

        $games = $query->get();
        $gameTypes = GameType::all();

        return view('dashboard', compact('games', 'gameTypes'));
    }

    public function show(Games $game)
    {
        return view('games.show', compact('game'));
    }

    public function create()
    {
        $gameTypes = GameType::all(); // haalt alle types op uit de database
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

        $validated['user_id'] = Auth::id(); // of auth()->id()

        Games::create($validated);

        // ✅ Check rol van gebruiker
        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.dashboard')->with('success', 'Game succesvol toegevoegd (admin)!');
        }

        return redirect()->route('dashboard')->with('success', 'Game succesvol toegevoegd!');
    }

    public function edit(Games $game) // ✅ gebruik model binding i.p.v. string $id
    {
        $gameTypes = GameType::all();
        return view('games.edit', compact('game', 'gameTypes'));
    }

    public function update(Request $request, Games $game) // ✅ model binding
    {
        // if (!auth()->user()?->isAdmin()) abort(403);

        $validated = $request->validate([
            'name' => 'required|max:255|unique:games,name,' . $game->id,
            'description' => 'required',
            'total_players' => 'required|integer|min:1',
            'game_type_id' => 'required|integer|exists:game_types,id',
        ]);

        $game->update($validated);

        return redirect()->route('dashboard')->with('success', 'Game succesvol bijgewerkt!');
    }

    public function destroy(Games $game) // ✅ model binding
    {
        $user = auth()->user();

        // alleen ingelogde gebruikers
        if (!$user) {
            abort(403, 'You must be logged in to perform this action.');
        }

        // als user GEEN admin is extra validatie
        if (!$user->isAdmin()) {
            // Mag alleen zijn eigen games verwijderen
            if ($user->id !== $game->user_id) {
                abort(403, 'You can only delete your own game');
            }

            // 🔍 Diepere validatie: moet minstens 3 games hebben toegevoegd
            $gameCount = Games::where('user_id', $user->id)->count();

            if ($gameCount < 3) {
                return back()->withErrors('You must have added at least 3 games before you can delete one.');
            }
        }

        // Admins mogen altijd verwijderen
        $game->delete();

        return redirect()->route('dashboard')->with('Game deleted successfully!');
    }
}
