@extends('layouts.app')

@section('title', $team->name . ' - Team Page')

@section('content')
<style>
    body {
        background-color: #12151c;
        margin: 0;
        padding: 0;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        min-height: 100vh;
    }

    .pageheader-section {
        min-height: 60vh;
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 40px 20px;
    }

    .profile-wrapper {
        width: 90%;
        max-width: 1200px;
        margin: 0 auto;
        padding: 30px;
        background-color: rgba(28, 31, 38, 0.95);
        border-radius: 12px;
        color: #fff;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
    }

    .profile-card {
        display: flex;
        align-items: center;
        gap: 40px;
        margin-bottom: 40px;
        padding-bottom: 30px;
        border-bottom: 1px solid #2a2e38;
    }

    .profile-avatar {
        width: 180px;
        height: 180px;
        border-radius: 12px;
        object-fit: cover;
        border: 3px solid #4da6ff;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
    }

    .profile-info {
        flex: 1;
    }

    .profile-name {
        font-size: 36px;
        font-weight: bold;
        margin-bottom: 10px;
        color: #fff;
    }

    .profile-description {
        font-size: 16px;
        color: #ddd;
    }

    .btn-primary {
        background-color: #4da6ff;
        color: white;
        border: none;
        padding: 12px 24px;
        border-radius: 6px;
        font-weight: 600;
        text-decoration: none;
        display: inline-block;
        margin-right: 10px;
        margin-top: 10px;
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        background-color: #3a8ad9;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(77, 166, 255, 0.3);
    }

    .section-title {
        font-size: 24px;
        margin-bottom: 20px;
        color: #fff;
        border-bottom: 2px solid #4da6ff;
        padding-bottom: 10px;
        display: inline-block;
    }

    .roster-container {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        margin-top: 20px;
    }

    .roster-member {
        display: flex;
        flex-direction: column;
        align-items: center; /* centraliza horizontalmente */
        justify-content: center; /* centraliza verticalmente */
        background-color: #2a2e38;
        padding: 20px;
        border-radius: 10px;
        text-align: center;
        width: 120px;
        color: #ccc;
        transition: all 0.3s ease;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    .roster-member:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
    }

    .roster-member img {
        width: 64px;
        height: 64px;
        border-radius: 50%;
        object-fit: cover;
        margin-bottom: 8px;
        border: 2px solid #4da6ff;
    }

    .roster-member-name {
        font-size: 14px;
        font-weight: 500;
        color: #fff;
    }

    .roster-member-role {
        font-size: 12px;
        color: #aaa;
    }

    @media (max-width: 768px) {
        .profile-card {
            flex-direction: column;
            text-align: center;
            gap: 20px;
        }

        .profile-info {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .roster-container {
            justify-content: center;
        }
    }

</style>

    <div style="padding-top: 100px;">
        <section class="pageheader-section" style="background-image: url('{{ asset('images/pageheader/bg.jpg') }}');">
            <div class="profile-wrapper">
                {{-- Team Card --}}
                <div class="profile-card">
                    <img class="profile-avatar" src="{{ $team->picture ? asset('images/team_pictures/' . $team->picture) : asset('images/team_pictures/default-team-picture.jpg') }}" alt="{{ $team->name }}">
                    <div class="profile-info">
                        <div class="profile-name">{{ $team->name }}</div>
                        <div class="profile-description">Líder: {{ $team->leader->name }}</div>
                        @auth
                            @if (Auth::id() === $team->leader_id)
                                <a href="{{ route('teams.manage', $team->id) }}" class="btn-primary">Gerenciar Time</a>
                                @can('update', $team)
                                <button onclick="generateInviteLink('{{ $team->id }}')" class="btn-primary">
                                    Generate Invite Link
                                </button>

                                <div id="invite-link-container-{{ $team->id }}" style="display: none; margin-top: 10px;">
                                    <div class="input-group">
                                        <input type="text" id="invite-link-{{ $team->id }}" class="form-control" readonly>
                                        <button class="btn btn-outline-secondary" onclick="copyInviteLink({{ $team->id }})">
                                            Copy
                                        </button>
                                    </div>
                                    <small class="text-muted">This link will expire in 7 days</small>
                                </div>
                                @endcan
                            @endif
                        @endauth
                    </div>
                </div>

                {{-- Roster --}}
                <div>
                    <h3 class="section-title">Integrantes</h3>
                    <div class="roster-container">
                        @foreach ($team->members as $member)
                            <div class="roster-member">
                                <img src="{{ $member->profile_picture ? asset('images/profile_pictures/' . $member->profile_picture) : asset('images/profile_pictures/default-profile-picture.jpg') }}" alt="{{ $member->name }}">
                                <div class="roster-member-name">
                                    <a href="{{ route('users.show', $member->name) }}" class="roster-member-name">
                                        {{ $member->name }}
                                    </a>
                                </div>
                                <div class="roster-member-role">
                                    {{ $member->pivot->role === 'active' ? 'Titular' : 'Reserva' }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    </div>

    <script>
        function generateInviteLink(teamId) {
            fetch(`/teams/${teamId}/invite`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                const container = document.getElementById(`invite-link-container-${teamId}`);
                const input = document.getElementById(`invite-link-${teamId}`);
                input.value = data.url;
                container.style.display = 'block';
            })

            .catch(error => {
                alert("Failed to generate invite.");
                console.error(error);
            });
        }

        function copyInviteLink(teamId) {
            const input = document.getElementById(`invite-link-${teamId}`);
            input.select();
            document.execCommand('copy');
            alert('Invite link copied to clipboard!');
        }
    </script>
@endsection
