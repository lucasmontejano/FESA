@extends('layouts.app')

@section('content')

@if(!$invite->isValid())
    <div class="alert alert-danger">
        This invite is no longer valid or the team is full
    </div>
@endif

<div class="container py-5" style="padding-top: 100px;">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow-lg border-0 rounded-lg overflow-hidden">
                {{-- Team Header --}}
                <div class="team-header" style="background: linear-gradient(135deg, #4da6ff 0%, #3385d6 100%); padding: 2rem; text-align: center;">
                    @if($invite->team->picture)
                    <img src="{{ asset('images/team_pictures/' . $invite->team->picture) }}" 
                         alt="{{ $invite->team->name }}"
                         class="team-logo mb-3"
                         style="width: 100px; height: 100px; object-fit: cover; border-radius: 50%; border: 3px solid white; box-shadow: 0 4px 12px rgba(0,0,0,0.15);">
                    @endif
                    <h3 class="text-white mb-1">{{ $invite->team->name }}</h3>
                    <p class="text-white-50 mb-0">Invited by {{ $invite->sender->name }}</p>
                </div>

                {{-- Invite Content --}}
                <div class="card-body p-4">
                    <div class="text-center mb-4">
                        <i class="icofont-id-card" style="font-size: 3rem; color: #4da6ff;"></i>
                        <h4 class="mt-3">Team Invitation</h4>
                        <p class="text-muted">Expires {{ $invite->expires_at->diffForHumans() }}</p>
                    </div>

                    @guest
                        <div class="alert alert-info text-center">
                            <p>Please login to accept this invitation</p>
                            <a href="{{ route('login') }}" class="btn btn-primary mt-2">
                                <i class="icofont-login"></i> Login
                            </a>
                        </div>
                    @endguest

                    @auth
                        @if($invite->team->members()->where('user_id', auth()->id())->exists())
                            <div class="alert alert-warning text-center">
                                <i class="icofont-info-circle"></i> You're already a member of this team
                            </div>
                            <a href="{{ route('teams.show', $invite->team) }}" class="btn btn-primary w-100">
                                <i class="icofont-team"></i> View Team
                            </a>
                        @else
                            <form method="POST" action="{{ route('teams.acceptInvite', $invite->token) }}">
                                @csrf
                                <button type="submit" class="btn btn-success btn-lg w-100 py-3" style="font-size: 1.1rem;">
                                    <i class="icofont-check-circled"></i> Accept Invitation
                                </button>
                            </form>
                        @endif
                    @endauth
                </div>

                {{-- Footer --}}
                <div class="card-footer text-center bg-light">
                    <small class="text-muted">Invitation will expire automatically</small>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .team-header {
        position: relative;
        overflow: hidden;
    }
    
    .team-header::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0,0,0,0.1);
    }
    
    .card {
        border: none;
        overflow: hidden;
        transition: transform 0.3s ease;
    }
    
    .card:hover {
        transform: translateY(-5px);
    }
    
    .btn-success {
        background: linear-gradient(135deg, #28a745 0%, #218838 100%);
        border: none;
        transition: all 0.3s ease;
    }
    
    .btn-success:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(40, 167, 69, 0.3);
    }
</style>
@endsection