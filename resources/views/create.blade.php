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
            <label for="primary_category_id">Primary Category</label>
            <select name="primary_category_id" class="form-control" required>
                <option value="">Select a primary category</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="secondary_category_id">Secondary Categories (Select up to 2)</label>
            <select name="secondary_category_id" class="form-control">
                <option value="">Select a secondary category</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
        <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
        <button type="submit" class="btn btn-primary">Create Card</button>
    </form>
@endsection
