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

                {{-- Message list --}}
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


        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            {{-- Add Game Button --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @auth
                        <a href="{{ route('games.create') }}"
                           class="inline-block px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition">
                            + Add Drinking Game
                        </a>
                    @endauth
                </div>
            </div>

            {{-- 🔍 Search & Filter --}}
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6 mb-6">
                <form method="GET" action="{{ route('dashboard') }}" class="flex flex-col sm:flex-row gap-4">
                    {{-- Zoekbalk --}}
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Search game..."
                           class="flex-1 px-4 py-2 rounded-md border border-gray-300 dark:border-gray-700
                      bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-gray-100
                      focus:ring-indigo-500 focus:border-indigo-500"/>

                    {{-- Filter op game type --}}
                    <select name="game_type"
                            class="px-4 py-2 rounded-md border border-gray-300 dark:border-gray-700
                       bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-gray-100">
                        <option value="">All types</option>
                        @foreach($gameTypes as $type)
                            <option value="{{ $type->id }}" {{ request('game_type') == $type->id ? 'selected' : '' }}>
                                {{ $type->name }}
                            </option>
                        @endforeach
                    </select>

                    {{-- Filter op aantal spelers --}}
                    <select name="players"
                            class="px-4 py-2 rounded-md border border-gray-300 dark:border-gray-700
                       bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-gray-100">
                        <option value="">All players</option>
                        <option value="2" {{ request('players') == 2 ? 'selected' : '' }}>2+</option>
                        <option value="4" {{ request('players') == 4 ? 'selected' : '' }}>4+</option>
                        <option value="6" {{ request('players') == 6 ? 'selected' : '' }}>6+</option>
                    </select>

                    {{-- Filterknop --}}
                    <button type="submit"
                            class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition">
                        Filter
                    </button>
                </form>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse ($games as $game)
                    <div
                        class="bg-white dark:bg-gray-800 rounded-xl shadow-md hover:shadow-xl transition transform hover:-translate-y-1">
                        <div class="p-6 space-y-3">
                            {{-- Game Info --}}
                            <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-100">
                                {{ $game->name }}
                            </h2>

                            <p class="text-sm text-gray-600 dark:text-gray-400 line-clamp-2">
                                {{ Str::limit($game->description, 100) }}
                            </p>

                            <div class="flex justify-between text-sm text-gray-500 dark:text-gray-400 mt-3">
                                <span>👥 {{ $game->total_players }} players</span>
                                <span>{{ $game->user->name ?? 'Unknown' }}</span>
                            </div>

                            {{-- 🔹 Actieknoppen --}}
                            <div
                                class="flex justify-between items-center mt-4 pt-3 border-t border-gray-200 dark:border-gray-700">
                                {{-- Bekijk --}}
                                <a href="{{ route('games.show', $game->id) }}"
                                   class="px-3 py-1 bg-blue-600 text-white text-sm rounded-md hover:bg-blue-700 transition">
                                    View
                                </a>

                                {{-- Bewerken (Admin of eigenaar) --}}
                                @auth
                                    @if(auth()->user()->isAdmin() || auth()->user()->id === $game->user_id)
                                        <a href="{{ route('games.edit', $game->id) }}"
                                           class="px-3 py-1 bg-yellow-500 text-white text-sm rounded-md hover:bg-yellow-600 transition">
                                            Edit
                                        </a>
                                    @endif

                                    {{--                                Verwijderen (alleen Admin)--}}
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
                @empty
                    <div class="col-span-full text-center text-gray-500 dark:text-gray-400">
                        No games found — add one above!
                    </div>
                @endforelse
            </div>
        </div>
</x-app-layout>
