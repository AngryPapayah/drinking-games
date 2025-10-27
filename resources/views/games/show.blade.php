<x-app-layout>
    <x-slot name="header">
        <h1 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $game->name ?? 'Game Details' }}
        </h1>
    </x-slot>

    <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 py-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100 space-y-6">
                @if(isset($game))
                    {{-- Game Info --}}
                    <div>
                        <h2 class="text-2xl font-bold text-indigo-600 dark:text-indigo-400 mb-3">{{ $game->name }}</h2>
                        <p class="text-gray-700 dark:text-gray-300 leading-relaxed">
                            {{ $game->description }}
                        </p>
                    </div>

                    <div class="flex flex-wrap gap-6 text-gray-600 dark:text-gray-400">
                        <div class="flex items-center space-x-2">
                            <span class="font-semibold">👥 Max players:</span>
                            <span>{{ $game->total_players }}</span>
                        </div>

                        <div class="flex items-center space-x-2">
                            <span class="font-semibold">🎲 Type:</span>
                            <span>{{ ucfirst($game->game_type_id) }}</span>
                        </div>

                        <div class="flex items-center space-x-2">
                            <span class="font-semibold">🧍 Created by:</span>
                            <span>User #{{ $game->user_id }}</span>
                        </div>
                    </div>

                    {{-- Back Button --}}
                    <div class="pt-6">
                        <a href="{{ route('dashboard') }}"
                           class="inline-block px-4 py-2 bg-gray-700 text-white rounded-md hover:bg-gray-800 transition">
                            ← Back to all games
                        </a>
                    </div>
                @else
                    <p class="text-gray-500 dark:text-gray-400">No game selected.</p>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
