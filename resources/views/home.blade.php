<x-layout>
    {{--    <x-slot name="header">--}}
    {{--        Yolo Header--}}
    {{--    </x-slot>--}}
    <h1>Welcome to BoozeFriends</h1>
    <a href="{{ route('games.create') }}">Add Drinking Game</a>

    {{--    @foreach($games as $game)--}}
    {{--        <h1><a href="{{ route('games.show', $game) }}">{{ $game->name }}</a></h1>--}}
    {{--    @endforeach--}}
</x-layout>
