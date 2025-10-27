@extends('layouts.app')

@section('content')
    <div class="max-w-2xl mx-auto bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 mt-6">

        <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100 mb-4">Game bewerken</h1>

        {{-- Succesmelding --}}
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        {{-- Formulier --}}
        <form method="POST" action="{{ route('games.update', $game->id) }}">
            @csrf
            @method('PUT')

            {{-- Game naam --}}
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Naam</label>
                <input
                    type="text"
                    id="name"
                    name="name"
                    value="{{ old('name', $game->name) }}"
                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500"
                    required
                >
                @error('name')
                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Beschrijving --}}
            <div class="mb-4">
                <label for="description"
                       class="block text-sm font-medium text-gray-700 dark:text-gray-300">Beschrijving</label>
                <textarea
                    id="description"
                    name="description"
                    rows="4"
                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500"
                    required
                >{{ old('description', $game->description) }}</textarea>
                @error('description')
                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Totaal aantal spelers --}}
            <div class="mb-4">
                <label for="total_players" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Aantal
                    spelers</label>
                <input
                    type="number"
                    id="total_players"
                    name="total_players"
                    value="{{ old('total_players', $game->total_players) }}"
                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500"
                    min="1"
                    required
                >
                @error('total_players')
                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Game Type --}}
            <div class="mb-4">
                <label for="game_type_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Game
                    Type</label>
                <select
                    name="game_type_id"
                    id="game_type_id"
                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500"
                    required
                >
                    @foreach($gameTypes as $type)
                        <option value="{{ $type->id }}" {{ $game->game_type_id == $type->id ? 'selected' : '' }}>
                            {{ $type->name }}
                        </option>
                    @endforeach
                </select>
                @error('game_type_id')
                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Opslaan knop --}}
            <div class="flex justify-between items-center">
                <button
                    type="submit"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-4 py-2 rounded-md"
                >
                    Wijzigingen opslaan
                </button>

                <a href="{{ route('dashboard') }}"
                   class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                    Annuleren
                </a>
            </div>
        </form>
    </div>
@endsection
