@extends('layouts.app')

@section('title', 'Meus Torneios')

@section('content')
    <!-- -----Banner----- -->
    <section class="banner-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="banner-content text-center">
                        <h2>Team Invitation URL</h2>
                        <p>Share this link with players you want to invite to {{ $team->name }}:</p>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" id="inviteUrl" value="{{ $inviteUrl }}" readonly>
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="button" onclick="copyInviteUrl()">Copy URL</button>
                            </div>
                        </div>
                        <a href="{{ route('teams.show', $team->id) }}" class="btn btn-primary">Back to Team</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
                   
    <!-- -----Banner----- -->
@endsection