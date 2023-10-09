@extends('layouts.app')
@section('content')
    <form action="{{ route('cards.store') }}" method="post">
        @csrf
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>

        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="imageName">Image Name</label>
            <input type="text" name="imageName" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" class="form-control" required></textarea>
        </div>
        <div class="form-group">
            <label for="category_id">Types (Select up to 2)</label>
            <select name="category_id[]" class="form-control" multiple required>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
        <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
        <button type="submit" class="btn btn-primary">Create Card</button>
    </form>
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
@endsection
