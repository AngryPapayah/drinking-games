<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-extrabold text-gray-800 dark:text-gray-100 tracking-tight">
                    Admin Dashboard
                </h1>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                    Manage all games, monitor activity, and keep BoozeBuddies fun & fair
                </p>
            </div>
        </div>
    </x-slot>

    <div
        class="p-8 bg-gradient-to-br from-white to-gray-50 dark:from-gray-900 dark:to-gray-950 rounded-3xl shadow-xl border border-gray-200 dark:border-gray-800 transition-all duration-300">

        <!-- Welcome message -->
        <div class="mb-8">
            <p class="text-gray-700 dark:text-gray-200 text-lg">
                Welcome back,
                <span class="font-semibold text-indigo-600 dark:text-indigo-400">{{ $user->name }}</span>
                You’re logged in as <strong>Administrator</strong>.
            </p>
        </div>

        <!-- Add button -->
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

        <!-- Table -->
        <div class="overflow-hidden border border-gray-200 dark:border-gray-800 rounded-2xl shadow-sm">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-800">
                <thead class="bg-gray-100 dark:bg-gray-800/70 backdrop-blur-sm">
                <tr>
                    @foreach(['Name','Description','Type','Players','Actions'] as $heading)
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider
                                   text-gray-600 dark:text-gray-400">
                            {{ $heading }}
                        </th>
                    @endforeach
                </tr>
                </thead>

                <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-100 dark:divide-gray-800">
                @forelse($games as $game)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/70 transition-colors">
                        <td class="px-6 py-4 text-gray-900 dark:text-gray-100 font-medium">{{ $game->name }}</td>
                        <td class="px-6 py-4 text-gray-600 dark:text-gray-300">{{ Str::limit($game->description, 70) }}</td>
                        <td class="px-6 py-4 text-gray-700 dark:text-gray-200">{{ $game->gameType->name ?? '-' }}</td>
                        <td class="px-6 py-4 text-gray-700 dark:text-gray-200">{{ $game->total_players }}</td>
                        <td class="px-6 py-4 flex items-center gap-3">
                            <a href="{{ route('games.show', $game->id) }}"
                               class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 font-medium transition">
                                View
                            </a>
                            <a href="{{ route('games.edit', $game->id) }}"
                               class="text-green-600 hover:text-green-800 dark:text-green-400 dark:hover:text-green-300 font-medium transition">
                                Edit
                            </a>
                            <form action="{{ route('games.destroy', $game->id) }}" method="POST"
                                  onsubmit="return confirm('Are you sure you want to delete this game?')"
                                  class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 font-medium transition">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-6 text-center text-gray-500 dark:text-gray-400 italic">
                            No games found — time to create a new one!
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
