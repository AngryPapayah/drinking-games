<x-app-layout>
    <x-slot name="header">
        <h1 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            @if(Auth::check())
                Welcome, {{ Auth::user()->name }}
            @else
                Welcome, Guest
            @endif
        </h1>
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

        {{-- Error Message --}}
        @if ($errors->any())
            <div
                class="relative flex items-start gap-3 p-4 mb-6 rounded-xl border border-red-300 dark:border-red-700
               bg-red-50 dark:bg-red-900/30 text-red-800 dark:text-red-300 shadow-sm animate-fade-in">
                <div>
                    <p class="font-semibold">There was a problem with your request:</p>
                    <ul class="list-disc list-inside mt-1 space-y-0.5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        {{-- Add Game Button --}}
        @auth
            <div class="mb-6">
                <a href="{{ route('games.create') }}"
                   class="inline-flex items-center gap-2 px-5 py-2.5
                          bg-gradient-to-r from-indigo-600 to-indigo-500
                          text-white font-semibold rounded-xl shadow-md
                          hover:from-indigo-700 hover:to-indigo-600
                          focus:outline-none focus:ring-2 focus:ring-indigo-400
                          focus:ring-offset-2 dark:focus:ring-offset-gray-900
                          transition-all duration-200 ease-in-out">
                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    <span>Add New Drinking Game</span>
                </a>
            </div>
        @endauth

        {{-- Search & Filter --}}
        <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6 mb-6">
            <form method="GET" action="{{ route('dashboard') }}"
                  class="flex flex-col sm:flex-row sm:items-end flex-wrap gap-6">
                @csrf

                {{-- Zoekbalk --}}
                <div class="flex flex-col flex-1">
                    <label for="search" class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        Search games
                    </label>
                    <input type="text" name="search" id="search" value="{{ request('search') }}"
                           placeholder="Search game..."
                           class="px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-700
                          bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-gray-100
                          focus:ring-indigo-500 focus:border-indigo-500 transition"/>
                </div>

                {{-- Filter op game type --}}
                <div class="flex flex-col">
                    <label for="game_type" class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        Types games
                    </label>
                    <select name="game_type" id="game_type"
                            class="px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-700
                           bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-gray-100
                           focus:ring-indigo-500 focus:border-indigo-500 transition">
                        <option value="">All types</option>
                        @foreach($gameTypes as $type)
                            <option value="{{ $type->id }}" {{ request('game_type') == $type->id ? 'selected' : '' }}>
                                {{ $type->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Filterknop --}}
                <div class="flex flex-col justify-end">
                    <button type="submit"
                            class="px-6 py-2.5 bg-indigo-600 text-white font-medium rounded-lg
                           hover:bg-indigo-700 focus:outline-none focus:ring-2
                           focus:ring-indigo-400 focus:ring-offset-2 dark:focus:ring-offset-gray-900
                           transition-all duration-200 ease-in-out">
                        Filter
                    </button>
                </div>
            </form>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse ($games as $game)

                {{-- Alleen tonen als zichtbaar OF als de eigenaar of admin het is --}}
                @if($game->is_visible || (Auth::check() && (Auth::user()->isAdmin() || Auth::user()->id === $game->user_id)))
                    <div
                        class="bg-white dark:bg-gray-800 rounded-xl shadow-md hover:shadow-xl transition transform hover:-translate-y-1 relative">
                        <div class="p-6 space-y-3">
                            {{-- Game Info --}}
                            <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-100 flex items-center gap-2">
                                {{ $game->name }}
                            </h2>

                            <p class="text-sm text-gray-600 dark:text-gray-400 line-clamp-2">
                                {{ Str::limit($game->description, 100) }}
                            </p>

                            <div class="flex justify-between text-sm text-gray-500 dark:text-gray-400 mt-3">
                                <span>👥 {{ $game->total_players }} players</span>
                                <span>{{ $game->user->name ?? 'Unknown' }}</span>
                            </div>

                            {{-- Actieknoppen --}}
                            <div
                                class="flex justify-between items-center mt-4 pt-3 border-t border-gray-200 dark:border-gray-700">
                                {{-- Bekijk --}}
                                <a href="{{ route('games.show', $game->id) }}"
                                   class="px-3 py-1 bg-blue-600 text-white text-sm rounded-md hover:bg-blue-700 transition">
                                    View
                                </a>

                                @auth
                                    {{-- Bewerken --}}
                                    @if(auth()->user()->isAdmin() || auth()->user()->id === $game->user_id)
                                        <a href="{{ route('games.edit', $game->id) }}"
                                           class="px-3 py-1 bg-yellow-500 text-white text-sm rounded-md hover:bg-yellow-600 transition">
                                            Edit
                                        </a>
                                    @endif

                                    {{-- Verwijderen --}}
                                    @if(auth()->user()->isAdmin() || auth()->user()->id === $game->user_id)
                                        <form action="{{ route('games.destroy', $game->id) }}" method="POST"
                                              onsubmit="return confirm('Are you sure to delete this game??')"
                                              class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="px-3 py-1 bg-red-600 text-white text-sm rounded-md hover:bg-red-700 transition">
                                                Delete
                                            </button>
                                        </form>
                                    @endif
                                @endauth
                            </div>
                        </div>
                    </div>
                @endif

            @empty
                <div class="col-span-full text-center text-gray-500 dark:text-gray-400">
                    No games found — add one above!
                </div>
            @endforelse
        </div>
    </div>
</x-app-layout>
