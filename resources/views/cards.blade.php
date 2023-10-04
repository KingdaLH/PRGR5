@extends('layouts.app')

@section('content')
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
                <td>{{ $card->Types}}</td>
                <td>
                    <a href="{{ route('cards.delete', ['name' => $card->name]) }}" class="btn btn-danger">Delete</a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
