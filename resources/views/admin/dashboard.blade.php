<x-app-layout>
    <x-slot name="header">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">
            Admin Dashboard
        </h1>
    </x-slot>

    <div class="p-6 bg-white dark:bg-gray-800 rounded-lg shadow">
        <p class="text-gray-700 dark:text-gray-200">
            Welkom, {{ Auth::user()->name }}! Je bent ingelogd als <strong>Admin</strong>.
        </p>

        <div class="mt-6 space-y-3">
            <a href="{{ route('dashboard') }}"
               class="inline-block px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                Terug naar gebruikers-dashboard
            </a>
            <a href="#" class="inline-block px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                Beheer gebruikers
            </a>
            <a href="#" class="inline-block px-4 py-2 bg-yellow-600 text-white rounded-md hover:bg-yellow-700">
                Beheer games
            </a>
        </div>
    </div>
</x-app-layout>
