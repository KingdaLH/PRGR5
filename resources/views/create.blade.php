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
            <input type="text" name="name" class="form-control" required value="{{ old('name') }}">
        </div>
        <div class="form-group">
            <label for="imageName">Image Name</label>
            <input type="text" name="imageName" class="form-control" >
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" class="form-control" ></textarea>
        </div>
        <div class="form-group">`
            <label for="category_id">Types</label>
            <select name="category_id[]" class="form-control"  multiple>
                <option value="">Choose up to two types</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
        <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
        <button type="submit" class="btn btn-primary">Create Card</button>
    </form>
@endsection
