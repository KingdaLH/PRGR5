@extends('layouts.web')
@section('title')
    Home
@endsection
@section('content')
    <h1>List of Temtem</h1>

    @if (isset($temtemData))
        <div class="row">
            @foreach ($temtemData as $name => $data)
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="{{ $data['portraitWikiUrl'] }}" class="card-img-top" alt="{{ $name }} Image">
                        <div class="card-body">
                            <h5 class="card-title">{{ $name }}</h5>
                            <p class="card-text">
                                Types: {{ implode(', ', $data['types']) }}
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    @if (isset($error))
        <p class="text-danger">{{ $error }}</p>
    @endif
@endsection
