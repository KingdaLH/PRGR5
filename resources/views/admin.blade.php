@extends('layouts.app')

@section('content')
<table class = "table">
    <thead>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Role</th>
            <th>Actions</th>
        </tr>
    <tbody>
        @foreach ($users as $user)
            <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->isAdmin ? 'Admin' : 'User' }}</td>
                <td>
                    <a href="{{ route('admin.delete', ['id' => $user->id]) }}" class="btn btn-danger">Delete</a>
                    @if (!$user->isAdmin)
                        <a href="{{ route('admin.makeAdmin', ['id' => $user->id]) }}" class="btn btn-success">Make Admin</a>
                    @else
                        <a href="{{ route('admin.removeAdmin', ['id' => $user->id]) }}" class="btn btn-warning">Remove Admin</a>
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection
