@extends('layouts.app')

@section('content')

    <form action="{{ route('cards.index') }}" method="get">
        @csrf
        <input type="text" name="search" placeholder="Search cards">
        <select name="category[]" multiple>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
        </select>
        <button type="submit">Apply Filter</button>
    </form>

    <table class = "table">
        <thead>
        <tr>
            <th>Name</th>
            <th>Image Name</th>
            <th>Description</th>
            <th>Types</th>
        </tr>
        <tbody>
        @foreach ($cards as $card)
            <tr>
                <td>{{ $card->name }}</td>
                <td>{{ $card->imageName }}</td>
                <td>{{ $card->Description}}</td>
                <td>
                    @foreach($card->categories as $category)
                    {{ $category->name}}
                    @endforeach
                </td>
                <td>
                    @if ($card->is_enabled)
                        Enabled
                    @else
                        Disabled
                    @endif
                </td>
                <td>
                    @if (auth()->user()->id == $card->user_id)
                        <form action="{{ route('cards.delete', $card) }}" method="post">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>

                        <form action="{{ route('cards.toggle', $card) }}" method="post">
                            @csrf
                            <label for="is_enabled">Enable/Disable</label>
                            <input type="checkbox" name="is_enabled" {{ $card->is_enabled ? 'checked' : '' }}>
                            <button type="submit" class = "btn btn-warning">Save</button>
                        </form>
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <section>
        <p>You have {{$numberOfCards}} Favourite Heroes!</p>
        @if ($numberOfCards >= 6)
            <form action="{{ route('cards.deleteAll')}}" method="post">
                @csrf
                @method('DELETE')
                <button type="submit" id="thanos-snap-button" class="btn btn-danger">THANOS SNAP</button>
            </form>

            <script>
                document.getElementById('thanos-snap-button').addEventListener('click', function () {
                    if (confirm('Are you sure you want to perform the Thanos Snap? This will delete half of your heroes from existence.')) {
                        document.getElementById('thanos-snap-form').submit();
                    }
                });
            </script>
        @endif
    </section>
@endsection
