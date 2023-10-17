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
            <th>Categories</th>
        </tr>
        <tbody>
        @foreach ($cards as $card)
            <tr>
                <td>{{ $card->name }}</td>
                <td>{{ $card->imageName }}</td>
                <td>{{ $card->Description}}</td>
                <td>{{ $card->Types}}</td>
                <td>
                    @foreach($card->categories as $category)
                    {{ $category->name}}
                    @endforeach
                </td>
                <td>
                    <a href="{{ route('cards.delete', $card) }}" class="btn btn-danger">Delete</a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
