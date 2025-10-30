<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Games;
use App\Models\GameType;

class GameController extends Controller
{
    public function index()
    {
        $games = Games::all();
        return view('games.index', compact('games'));
    }

    public function dashboard(Request $request)
    {
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

        // 👇 Zet user_id server-side (veiliger dan hidden input)
        $validated['user_id'] = auth()->id();

        Games::create($validated);

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

        // ✅ $game bestaat nu; check eigenaar of admin
        if (!$user || (!$user->isAdmin() && $user->id !== $game->user_id)) {
            abort(403, 'Je hebt geen rechten om deze game te verwijderen.');
        }

        $game->delete();

        return redirect()->route('dashboard')->with('success', 'Game succesvol verwijderd!');
    }
}
