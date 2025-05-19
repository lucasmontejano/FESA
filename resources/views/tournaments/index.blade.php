@extends('layouts.app')

@section('title', 'Meus Torneios')

@section('content')
<div class="container">
    <h1>All Tournaments</h1>
    
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="row">
        @foreach($tournaments as $tournament)
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{ $tournament->name }}</h5>
                    <p class="card-text">{{ $tournament->description }}</p>
                    <p class="text-muted">
                        Created by: {{ $tournament->creator->name }}
                        <br>
                        Max Participants: {{ $tournament->max_participants }}
                    </p>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection