<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Games;

//use function Laravel\Prompts\error;

class GameController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function home()
    {
        $games = Games::all();
        return view('games.index', compact('games'));
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
        return view('games.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        /** @var array $validated */
        $request->validate([
            'name' => 'required|unique:games|max:255',
            'description' => 'required',
            'total_players' => 'required|integer|min:1',
        ]);
        return redirect()->route('games.show', ['game' => $game->id]);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
