<x-app-layout>
    <x-slot name="header">
        <h1 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Welcome to BoozeFriends
        </h1>
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        {{-- Add Game Button --}}
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <a href="{{ route('games.create') }}"
                   class="inline-block px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition">
                    + Add Drinking Game
                </a>
            </div>
        </div>

        {{-- Game Cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse ($games as $game)
                <a href="{{ route('games.show', $game->id) }}"
                   class="block bg-white dark:bg-gray-800 rounded-xl shadow-md hover:shadow-xl transition transform hover:-translate-y-1">
                    <div class="p-6 space-y-3">
                        <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-100">
                            {{ $game->name }}
                        </h2>
                        <p class="text-sm text-gray-600 dark:text-gray-400 line-clamp-2">
                            {{ Str::limit($game->description, 100) }}
                        </p>

                        <div class="flex justify-between text-sm text-gray-500 dark:text-gray-400 mt-3">
                            <span>👥 {{ $game->total_players }} players</span>
                            <span> {{ ucfirst($game->game_type_id) }}</span>
                        </div>
                    </div>
                </a>
            @empty
                <div class="col-span-full text-center text-gray-500 dark:text-gray-400">
                    No games found — add one above!
                </div>
            @endforelse
        </div>
    </div>
</x-app-layout>
