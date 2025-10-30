<x-app-layout>

    <x-slot name="header">
        <h1 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Add a New Game
        </h1>
    </x-slot>

    <div class="max-w-2xl mx-auto py-10">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <form method="POST" action="{{ route('games.store') }}" class="space-y-6">
                    @csrf

                    Game Name
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Name of Game
                        </label>
                        <input
                            type="text"
                            name="name"
                            id="name"
                            value="{{ old('name') }}"
                            required
                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500"
                        />
                        @error('name')
                        <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    Description
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Summary
                        </label>
                        <textarea
                            id="description"
                            name="description"
                            rows="3"
                            required
                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500"
                        >{{ old('description') }}</textarea>
                        @error('description')
                        <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    Max Players
                    <div>
                        <label for="total_players" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Max Players
                        </label>
                        <input
                            type="number"
                            name="total_players"
                            id="total_players"
                            min="1"
                            value="{{ old('total_players') }}"
                            required
                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500"
                        />
                        @error('total_players')
                        <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    Game Type
                    <div>
                        <label for="game_type_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Game Type
                        </label>
                        <select
                            name="game_type_id"
                            id="game_type_id"
                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500"
                            required
                        >
                            <option value="">-- Please choose an option --</option>
                            @foreach($gameTypes as $type)
                                <option
                                    value="{{ $type->id }}" {{ old('game_type_id') == $type->id ? 'selected' : '' }}>
                                    {{ $type->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('game_type_id')
                        <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    Hidden User ID
                    <input type="hidden" name="user_id" value="{{ auth()->id() }}"/>

                    Submit Button
                    <div class="flex justify-end">
                        <button
                            type="submit"
                            class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150"
                        >
                            Save Game
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
