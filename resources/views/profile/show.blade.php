@extends('layouts.app')

@section('title', $user->nickname . "'s Profile")

@section('content')
<style>
    

    .pageheader-section {
        min-height: 120vh;
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
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid #4da6ff;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        transition: transform 0.3s ease;
    }

    .profile-avatar:hover {
        transform: scale(1.05);
    }

    .profile-info {
        flex: 1;
    }

    .profile-name {
        font-size: 36px;
        font-weight: bold;
        margin-bottom: 15px;
        color: #fff;
    }

    .profile-description {
        margin-top: 15px;
        font-size: 16px;
        color: #ddd;
        line-height: 1.6;
        max-width: 800px;
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
        margin-top: 20px;
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        background-color: #3a8ad9;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(77, 166, 255, 0.3);
    }

    .tab-navigation {
        margin: 20px auto 30px;
        display: flex;
        justify-content: center;
        background-color: #2a2e38;
        border-radius: 12px;
        overflow: hidden;
        width: 100%;
        max-width: 800px;
    }

    .tab-link {
        flex: 1;
        text-align: center;
        padding: 18px 0;
        cursor: pointer;
        color: #ddd;
        background-color: #2a2e38;
        border: none;
        font-weight: 600;
        font-size: 18px;
        transition: all 0.3s ease;
    }

    .tab-link:hover {
        background-color: #353a47;
    }

    .tab-link.active {
        background-color: #4da6ff;
        color: #fff;
    }

    .tab-section {
        display: none;
        padding: 20px;
        min-height: 300px;
    }

    .tab-section.active {
        display: block;
        animation: fadeIn 0.5s ease;
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    .list-block {
        list-style: none;
        padding: 0;
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 20px;
    }

    .list-item {
        background-color: #2a2e38;
        padding: 20px;
        border-radius: 10px;
        color: #ddd;
        transition: all 0.3s ease;
        border-left: 4px solid #4da6ff;
        height: 100%;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    .list-item:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
    }

    .list-item a {
        color: #4da6ff;
        text-decoration: none;
        font-weight: 600;
        font-size: 18px;
        display: block;
        margin-bottom: 8px;
    }

    .list-item a:hover {
        color: #7dbeff;
    }

    .list-item span {
        color: #aaa;
        font-size: 14px;
    }

    .section-title {
        font-size: 24px;
        margin-bottom: 20px;
        color: #fff;
        border-bottom: 2px solid #4da6ff;
        padding-bottom: 10px;
        display: inline-block;
    }

    .text-light {
        color: #ccc;
        font-size: 16px;
        text-align: center;
        margin-top: 40px;
    }

    .empty-state {
        text-align: center;
        padding: 40px 0;
    }

    .empty-state-icon {
        font-size: 48px;
        color: #4da6ff;
        margin-bottom: 20px;
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

        .list-block {
            grid-template-columns: 1fr;
        }
    }

    .btn-create-team {
    background-color: #4da6ff; /* Primary blue from your theme */
    color: white;
    border: none;
    padding: 8px 16px;       /* Adjust padding as needed */
    border-radius: 6px;
    font-weight: 600;
    text-decoration: none;
    display: inline-block;
    transition: all 0.3s ease;
    font-size: 0.9em;         /* Slightly smaller or adjust to match design */
}

.btn-create-team:hover {
    background-color: #3a8ad9; /* Darker blue on hover */
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(77, 166, 255, 0.2); /* Consistent shadow effect */
}

/* Ensure section-title style is as you expect (from your existing styles) */
.section-title {
    font-size: 24px;
    /* margin-bottom: 20px; -- This is now handled by the parent flex div */
    color: #fff;
    border-bottom: 2px solid #4da6ff;
    padding-bottom: 10px;
    display: inline-block; /* This property remains if you want the border only under the text */
}

/* Optional: Styles for team items if not already present (adjust as needed) */
.team-item {
    display: flex;
    align-items: center;
    gap: 15px; /* Adds space between photo and info */
}

.team-photo {
    width: 50px; /* Or your preferred size */
    height: 50px;
    border-radius: 50%;
    object-fit: cover; /* Ensures the image covers the area without distortion */
}

.team-info a {
    /* Your existing styles for team links */
    font-weight: 600; /* Ensure this is applied */
}

.team-info span {
    /* Your existing styles for role info */
    font-size: 0.9em; /* Ensure this is applied */
    color: #aaa; /* Ensure this is applied */
}
</style>

<section class="pageheader-section" style="background-image: url(images/pageheader/bg.jpg);">
    <div class="profile-wrapper">
        {{-- Profile Card --}}
        <div class="profile-card">
            @auth
                @if (Auth::id() === $user->id)
                    <form id="profile-picture-form" action="{{ route('profile.updatePicture', $user->nickname) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <label for="profile-picture-input" style="cursor: pointer;">
                            <img class="profile-avatar" id="profile-avatar-preview"
                                src="{{ $user->profile_picture ? asset('images/profile_pictures/' . $user->profile_picture) : asset('images/profile_pictures/default-profile-picture.jpg') }}"
                                alt="{{ $user->nickname }}">
                        </label>
                        <input type="file" name="profile_picture" id="profile-picture-input" accept="image/*" style="display: none;" onchange="document.getElementById('profile-picture-form').submit();">
                    </form>
                @else
                    <img class="profile-avatar"
                        src="{{ $user->profile_picture ? asset('images/profile_pictures/' . $user->profile_picture) : asset('images/profile_pictures/default-profile-picture.jpg') }}"
                        alt="{{ $user->nickname }}">
                @endif
            @endauth

           <div class="profile-info">
                <div class="profile-name">{{ $user->nickname }}</div>
                <div class="profile-description" id="description-display">
                    {{ $user->description ?? '' }}
                </div>

                <form id="description-form" action="{{ route('profile.updateDescription', $user->nickname) }}" method="POST" style="display: none;">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="redirect_url" value="{{ url()->current() }}">
                    <textarea name="description" rows="4" style="width: 100%; padding: 10px; border-radius: 6px; background: #2a2e38; color: #fff; border: 1px solid #444;">{{ $user->description }}</textarea>
                    <div style="margin-top: 10px; display: flex; gap: 10px;">
                        <button type="submit" class="btn-primary" style="padding: 10px 24px; background-color: #4da6ff; border: none; border-radius: 6px; font-weight: 600;">Salvar</button>
                        <button type="button" onclick="toggleDescriptionEdit()" class="btn-primary" style="padding: 10px 24px; background-color: #6c757d; color: #fff; border: none; border-radius: 6px; font-weight: 600;">Cancelar</button>
                    </div>
                </form>

                @auth
                    @if (Auth::id() === $user->id)
                        <button onclick="toggleDescriptionEdit()" class="btn-primary" style="margin-top: 10px; padding: 8px 20px; background-color: #4da6ff; border: none; border-radius: 6px; font-weight: 600;">Editar Descrição</button>
                    @endif
                @endauth
            </div>
        </div>

        {{-- Tab Navigation --}}
        <div class="tab-navigation">
            <button class="tab-link {{ $activeTab === 'teams' ? 'active' : '' }}" data-tab="teams">Meus Times</button>
            <button class="tab-link {{ $activeTab === 'tournaments' ? 'active' : '' }}" data-tab="tournaments">Torneios</button>
        </div>

        {{-- Tournaments Tab --}}
        <div id="tournaments" class="tab-section {{ ($activeTab ?? 'tournaments') === 'tournaments' ? 'active' : '' }}">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <h3 class="section-title" style="margin-bottom: 0;">Meus Torneios</h3>
            </div>

            @if (isset($myRelevantTournaments) && $myRelevantTournaments->count() > 0)
                <ul class="list-block">
                    @foreach ($myRelevantTournaments as $tournament)
                        <li class="list-item">
                            <div class="tournament-item" style="display: flex; align-items: center; gap: 15px;">
                                <a href="{{ route('tournaments.show', $tournament->id) }}" style="flex-shrink: 0;">
                                    <img class="tournament-banner-thumbnail"
                                        src="{{ $tournament->banner ? asset($tournament->banner) : asset('images/default-tournament-banner.png') }}"
                                        alt="{{ $tournament->name }} Banner"
                                        style="width: 120px; height: 70px; object-fit: cover; border-radius: 4px; border: 1px solid #444;">
                                </a>
                                <div class="tournament-info" style="flex-grow: 1;">
                                    <a href="{{ route('tournaments.show', $tournament->id) }}" style="font-size: 1.1em; color: #4da6ff; text-decoration: none; font-weight: 600; display: block; margin-bottom: 5px;" title="{{ $tournament->name }}">
                                        {{ \Illuminate\Support\Str::limit($tournament->name, 15) }}
                                    </a>
                                    <span style="font-size: 0.9em; color: #aaa; display: block; margin-bottom: 3px;">
                                        Jogo: {{ $tournament->game ?? 'N/A' }}
                                    </span>
                                    <span style="font-size: 0.9em; color: #aaa; display: block;">
                                        Data: {{ \Carbon\Carbon::parse($tournament->tournament_date . ' ' . $tournament->time)->translatedFormat('d/m/Y \à\s H:i') }} 
                                    </span>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @else
                <div class="empty-state">
                    <div class="empty-state-icon">🏆</div>
                    <p class="text-light">{{ $user->nickname }} não está participando de nenhum torneio atualmente (via suas equipes).</p>
                </div>
            @endif
        </div>

        {{-- Teams Tab --}}
        <div id="teams" class="tab-section {{ ($activeTab ?? 'teams') === 'teams' ? 'active' : '' }}"> {{-- Assuming you might use the $activeTab default logic we discussed --}}
            {{-- Flex container for Title and Button --}}
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <h3 class="section-title" style="margin-bottom: 0;">My Teams</h3>
                <a href="{{ route('teams.create') }}" class="btn-create-team">
                    Criar Time
                </a>
            </div>

            @if ($user->teams->count() > 0)
                <ul class="list-block">
    @foreach ($user->teams as $team)
        <li class="list-item">
            <div class="team-item" style="display: flex; align-items: center;">
                {{-- Imagem do Time (sem alterações) --}}
                <img class="team-photo" 
                     src="{{ $team->picture ? asset('images/team_pictures/' . $team->picture) : asset('images/team_pictures/default-team-logo.png') }}" 
                     alt="{{ $team->name }}" 
                     style="width: 50px; height: 50px; border-radius: 50%; margin-right: 15px; object-fit: cover; flex-shrink: 0;"> {{-- Adicionado flex-shrink: 0 --}}
                
                <div class="team-info flex-1 min-w-0">

                    <a href="{{ route('teams.show', $team->id) }}" 
                       title="{{ $team->name }}"
                       class="block truncate text-lg font-semibold text-blue-400 hover:text-blue-300 transition-colors">
                        {{ $team->name }}
                    </a>

                    <span style="font-size: 14px; color: #aaa; display: block;">
                        ({{ $team->pivot->role === 'active' ? 'Titular' : ($team->pivot->role === 'backup' ? 'Reserva' : $team->pivot->role) }})
                    </span>
                </div>
            </div>
        </li>
    @endforeach
</ul>
            @else
                <div class="empty-state">
                    <div class="empty-state-icon">👥</div>
                    <p class="text-light">{{ $user->nickname }} ainda não está em nenhum time.</p>
                </div>
            @endif
        </div>
    </div>
</section>

<script>
    const tabs = document.querySelectorAll('.tab-link');
    const sections = document.querySelectorAll('.tab-section');

    tabs.forEach(tab => {
        tab.addEventListener('click', () => {
            tabs.forEach(t => t.classList.remove('active'));
            sections.forEach(s => s.classList.remove('active'));

            tab.classList.add('active');
            document.getElementById(tab.dataset.tab).classList.add('active');
        });
    });

    function toggleDescriptionEdit() {
        const display = document.getElementById('description-display');
        const form = document.getElementById('description-form');
        
        if (display.style.display === 'none') {
            display.style.display = 'block';
            form.style.display = 'none';
        } else {
            display.style.display = 'none';
            form.style.display = 'block';
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
    const tabs = document.querySelectorAll('.tab-link');
    const sections = document.querySelectorAll('.tab-section');

    tabs.forEach(tab => {
        tab.addEventListener('click', () => {
            tabs.forEach(t => t.classList.remove('active'));
            sections.forEach(s => s.classList.remove('active'));

            tab.classList.add('active');
            const targetSection = document.getElementById(tab.dataset.tab);
            if (targetSection) {
                targetSection.classList.add('active');
            }
        });
    });

    window.toggleDescriptionEdit = function() {
        const display = document.getElementById('description-display');
        const form = document.getElementById('description-form');
        
        if (display.style.display === 'none') {
            display.style.display = 'block';
            form.style.display = 'none';
        } else {
            display.style.display = 'none';
            form.style.display = 'block';
        }
    };
});
</script>

@endsection
