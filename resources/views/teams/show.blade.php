@extends('layouts.app')

@section('title', 'Meus Torneios')

@section('content')
    <!-- -----Banner----- -->
    <style>
    .team-details-header {
        display: flex;
        align-items: center;
    }

    .team-picture img {
        width: 80px;
        height: 80px;
        border-radius: 8px;
        object-fit: cover;
    }

    .team-info {
        margin-left: 20px;
    }

    .team-management-links {
        margin-bottom: 20px;
    }

    .roster-container {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        margin-top: 20px;
    }

    .roster-member {
        text-align: center;
        width: 100px;
    }

    .roster-member img {
        width: 64px;
        height: 64px;
        border-radius: 50%;
        object-fit: cover;
        margin-bottom: 8px;
    }

    .roster-member-name {
        font-size: 14px;
        font-weight: 500;
    }

    .roster-member-role {
        font-size: 12px;
        color: #888;
    }
    </style>

    <section class="banner-section" style="background-image: url('{{ asset('images/pageheader/bg.jpg') }}');">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-12">
                    <div class="banner-content text-center">
                        <h2>Team Details</h2>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="team-details-section padding-top padding-bottom">
        <div class="container">
            <div class="team-details">
                <div class="team-details-header mb-4">
                    <div class="team-picture">
                        <img src="{{ $team->picture ? asset('images/team_pictures/' . $team->picture) : asset('images/team/default.png') }}" alt="{{ $team->name }}">
                    </div>
                    <div class="team-info">
                        <h3>{{ $team->name }}</h3>
                        <p>Leader: {{ $team->leader->name }}</p>
                    </div>
                </div>

                @auth
                    @if (Auth::id() === $team->leader_id)
                        <div class="team-management-links">
                            <a href="{{ route('teams.manage', $team->id) }}" class="btn btn-primary">Manage Team</a>
                            <a href="{{ route('teams.generateInviteUrl', $team->id) }}" class="btn btn-secondary ml-2">Generate Invite URL</a>
                        </div>
                    @endif
                @endauth

                <h4>Roster</h4>
                <div class="roster-container">
                    @foreach ($team->members as $member)
                        <div class="roster-member">
                            <img src="{{ $member->profile_picture ? asset('images/profile_pictures/' . $member->profile_picture) : asset('images/player/default.png') }}" alt="{{ $member->name }}">
                            <div class="roster-member-name">{{ $member->name }}</div>
                            <div class="roster-member-role">{{ ucfirst($member->pivot->role) }}</div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>          
    <!-- -----Banner----- -->
@endsection