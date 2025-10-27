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
                            <span>{{ $game->gameType->name ?? 'N/A' }}</span>
                        </div>

                        {{-- 🔹 Actieknoppen --}}
                        <div
                            class="flex justify-between items-center mt-4 pt-3 border-t border-gray-200 dark:border-gray-700">
                            {{-- Bekijk --}}
                            <a href="{{ route('games.show', $game->id) }}"
                               class="px-3 py-1 bg-blue-600 text-white text-sm rounded-md hover:bg-blue-700 transition">
                                Bekijk
                            </a>

                            {{-- Bewerken (Admin of eigenaar) --}}
                            @auth
                                @if(auth()->user()->isAdmin() || auth()->user()->id === $game->user_id)
                                    <a href="{{ route('games.edit', $game->id) }}"
                                       class="px-3 py-1 bg-yellow-500 text-white text-sm rounded-md hover:bg-yellow-600 transition">
                                        Bewerken
                                    </a>
                                @endif

                                {{-- Verwijderen (alleen Admin) --}}
                                @if(auth()->user()->isAdmin() || auth()->user()->id === $game->user_id)
                                    <form action="{{ route('games.destroy', $game->id) }}" method="POST"
                                          onsubmit="return confirm('Weet je zeker dat je deze game wilt verwijderen?')"
                                          class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="px-3 py-1 bg-red-600 text-white text-sm rounded-md hover:bg-red-700 transition">
                                            Verwijderen
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
