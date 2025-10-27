<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Games;
use App\Models\GameType;

//use function Laravel\Prompts\error;

class GameController extends Controller
{
    /**
     * Display a listing of the resource.
     */
//    public function home()
//    {
//        $games = Games::all();
//        return view('games.index', compact('games'));
//    }
    public function index()
    {
        $games = Games::all();
        return view('games.index', compact('games'));
    }


    public function dashboard()
    {
        // Haal alle games op uit de database
        $games = Games::all();

        // Stuur ze door naar de dashboard view
        return view('dashboard', compact('games'));
    }


    public function show(Games $game)
    {
        return view('games.show', compact('game'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Alleen ingelogde gebruikers mogen games toevoegen
        if (!auth()->check()) {
            abort(403, 'Je moet ingelogd zijn om een game toe te voegen.');
        }

        $gameTypes = GameType::all();
        return view('games.create', compact('gameTypes'));
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        if (!auth()->check()) {
            abort(403, 'Je moet ingelogd zijn om een game toe te voegen.');
        }

        $validated = $request->validate([
            'name' => 'required|unique:games|max:255',
            'description' => 'required',
            'total_players' => 'required|integer|min:1',
            'user_id' => 'required|integer',
            'game_type_id' => 'required|integer|exists:game_types,id',
        ]);


        Games::create($validated);

        return redirect()->route('dashboard')->with('success', 'Game succesvol toegevoegd!');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Alleen admins mogen games bewerken
        if (!auth()->user() || !auth()->user()->isAdmin()) {
            abort(403, 'Alleen admins mogen games bewerken.');
        }

        $gameTypes = GameType::all();
        return view('games.edit', compact('game', 'gameTypes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
//        if (!auth()->user() || !auth()->user()->isAdmin()) {
//            abort(403, 'Alleen admins mogen games bijwerken.');
//        }
//
//        $validated = $request->validate([
//            'name' => 'required|max:255|unique:games,name,' . $game->id,
//            'description' => 'required',
//            'total_players' => 'required|integer|min:1',
//            'user_id' => 'required|integer',
//            'game_type_id' => 'required|integer|exists:game_types,id',
//        ]);
//
//        $game->update($validated);
//
//        return redirect()->route('dashboard')->with('success', 'Game succesvol bijgewerkt!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = auth()->user();

        // Controle: alleen admin of eigenaar mag verwijderen
        if (!$user || (!$user->isAdmin() && $user->id !== $game->user_id)) {
            abort(403, 'Je hebt geen rechten om deze game te verwijderen.');
        }

        $game->delete();

        return redirect()->route('dashboard')->with('success', 'Game succesvol verwijderd!');
    }
}
