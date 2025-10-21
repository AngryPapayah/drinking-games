<x-app-layout>
    @if(isset($game))
        <h1>{{ $game->name }}</h1>
        <li>Description: {{ $game->description }}</li>
        <li>Max players: {{ $game->total_players }}</li>
    @else
        <p>No game selected.</p>
    @endif
</x-app-layout>
