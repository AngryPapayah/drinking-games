<x-app-layout>
    <form method="POST" action="{{route('games.store') }}">
        @csrf

        <h2>Add new game</h2>

        <div>
            <label for="name">Name of game:</label><br>
            <input type="text" name="name" required>

        </div>

        <div>
            <label for="description">Summary:</label><br>
            <textarea id="description" name="description" rows="3" required></textarea>
        </div>

        <div>
            <label for="total_players">Max players:</label><br>
            <input type="number" name="total_players" min="1" required>
        </div>

        <div>
            <label for="game_type_id">Game type:</label>
            <select name="game_type_id">
                <option value="">--Please choose an option--</option>
                <option value="card">Card</option>
                <option value="board">Board</option>
                <option value="strategy">Strategy</option>
            </select>

        </div>

        <input type="hidden" name="user_id" value="{{ auth()->id() }}"/>

        <button type="submit">Save</button>
    </form>
</x-app-layout>
