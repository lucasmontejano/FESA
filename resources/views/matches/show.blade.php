@extends('layouts.app')
@section('title', ($match->team1 ? $match->team1->name : 'Equipe A') . ' vs ' . ($match->team2 ? $match->team2->name : 'Equipe B'))
@section('content')
<style>
    /* Enhanced custom styles for match page */
    .match-card {
        background: linear-gradient(145deg, #2d3748, #1a202c);
        border: 1px solid #4a5568;
        box-shadow: 0 20px 40px rgba(0,0,0,0.4), 0 0 0 1px rgba(255,255,255,0.05);
        backdrop-filter: blur(10px);
        position: relative;
        overflow: hidden;
    }
    
    .match-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 1px;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
    }
    
    .team-card {
        transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        position: relative;
    }
    
    .team-card:hover {
        transform: translateY(-5px);
    }
    
    .team-card.loser {
        opacity: 0.4;
        transform: scale(0.92) translateY(5px);
        filter: grayscale(0.7);
    }
    
    .team-card.winner {
        transform: scale(1.05);
        filter: drop-shadow(0 0 20px rgba(104, 211, 145, 0.3));
    }
    
    .team-card.winner .team-logo {
        border-color: #68d391;
        box-shadow: 0 0 30px rgba(104, 211, 145, 0.4);
        animation: winner-glow 2s ease-in-out infinite alternate;
    }
    
    @keyframes winner-glow {
        from { box-shadow: 0 0 20px rgba(104, 211, 145, 0.4); }
        to { box-shadow: 0 0 35px rgba(104, 211, 145, 0.6); }
    }
    
    .team-logo {
        transition: all 0.3s ease;
        box-shadow: 0 8px 25px rgba(0,0,0,0.3);
    }
    
    .team-logo:hover {
        transform: scale(1.1);
        box-shadow: 0 12px 35px rgba(0,0,0,0.5);
    }
    
    .vs-separator {
        color: #718096;
        font-weight: 900;
        font-size: 3rem;
        line-height: 1;
        text-shadow: 0 2px 10px rgba(0,0,0,0.5);
        background: linear-gradient(45deg, #718096, #a0aec0);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    
    .score-display {
        background: linear-gradient(135deg, rgba(255,255,255,0.1), rgba(255,255,255,0.05));
        border-radius: 20px;
        padding: 1.5rem;
        backdrop-filter: blur(5px);
        border: 1px solid rgba(255,255,255,0.1);
        margin: 1rem 0;
    }
    
    .score-number {
        background: linear-gradient(135deg, #ffffff, #e2e8f0);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        text-shadow: 0 2px 10px rgba(0,0,0,0.3);
        font-weight: 900;
        letter-spacing: -0.02em;
    }
    
    /* Enhanced status badges */
    .status-badge {
        padding: 8px 20px;
        border-radius: 25px;
        font-weight: 700;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        border: 2px solid transparent;
        backdrop-filter: blur(5px);
    }
    
    .status-pending {
        background: linear-gradient(135deg, #718096, #4a5568);
        color: white;
        border-color: rgba(255,255,255,0.2);
    }
    
    .status-live {
        background: linear-gradient(135deg, #f6ad55, #ed8936);
        color: white;
        animation: live-pulse 1.5s ease-in-out infinite;
        border-color: rgba(255,255,255,0.3);
    }
    
    @keyframes live-pulse {
        0%, 100% { transform: scale(1); box-shadow: 0 4px 15px rgba(237, 137, 54, 0.4); }
        50% { transform: scale(1.05); box-shadow: 0 6px 25px rgba(237, 137, 54, 0.6); }
    }
    
    .status-completed {
        background: linear-gradient(135deg, #f56565, #e53e3e);
        color: white;
        border-color: rgba(255,255,255,0.2);
    }
    
    /* Tournament header enhancements */
    .tournament-header {
        background: linear-gradient(135deg, rgba(0,0,0,0.4), rgba(0,0,0,0.2));
        backdrop-filter: blur(10px);
        border-radius: 15px;
        padding: 2rem;
        margin-bottom: 3rem;
        border: 1px solid rgba(255,255,255,0.1);
        box-shadow: 0 10px 30px rgba(0,0,0,0.3);
    }
    
    .tournament-title {
        background: linear-gradient(135deg, #63b3ed, #4299e1);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        transition: all 0.3s ease;
    }
    
    .tournament-title:hover {
        background: linear-gradient(135deg, #90cdf4, #63b3ed);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        transform: translateY(-2px);
    }
    
    /* Admin panel enhancements */
    .admin-panel {
        background: linear-gradient(135deg, #2d3748, #1a202c);
        border: 1px solid #4a5568;
        box-shadow: 0 15px 35px rgba(0,0,0,0.4);
        backdrop-filter: blur(10px);
        position: relative;
        overflow: hidden;
    }
    
    .admin-panel::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 2px;
        background: linear-gradient(90deg, #68d391, #48bb78, #68d391);
    }
    
    .admin-form input[type="radio"] {
        appearance: none;
        -webkit-appearance: none;
        width: 28px;
        height: 28px;
        border: 3px solid #9ca3af;
        border-radius: 50%;
        outline: none;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        position: relative;
        background: rgba(255,255,255,0.05);
    }
    
    .admin-form input[type="radio"]:hover {
        border-color: #60a5fa;
        transform: scale(1.1);
        box-shadow: 0 0 15px rgba(96, 165, 250, 0.3);
    }
    
    .admin-form input[type="radio"]:checked {
        border-color: #68d391;
        background: linear-gradient(135deg, #68d391, #48bb78);
        box-shadow: 0 0 0 4px rgba(31, 35, 51, 0.8), 0 0 0 7px rgba(104, 211, 145, 0.4);
        transform: scale(1.15);
    }
    
    .admin-form input[type="radio"]:checked::after {
        content: '✓';
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        color: white;
        font-size: 14px;
        font-weight: bold;
    }
    
    .admin-submit-btn {
        background: linear-gradient(135deg, #48bb78, #38a169);
        transition: all 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        box-shadow: 0 6px 20px rgba(72, 187, 120, 0.3);
        border: 2px solid transparent;
    }
    
    .admin-submit-btn:hover {
        background: linear-gradient(135deg, #38a169, #2f855a);
        transform: translateY(-2px) scale(1.02);
        box-shadow: 0 10px 30px rgba(72, 187, 120, 0.4);
        border-color: rgba(255,255,255,0.2);
    }
    
    .admin-submit-btn:active {
        transform: translateY(0) scale(0.98);
    }
    
    /* Team name styling */
    .team-name {
        text-shadow: 0 2px 8px rgba(0,0,0,0.3);
        font-weight: 600;
        transition: all 0.3s ease;
    }
    
    .team-name:hover {
        color: #90cdf4;
        text-shadow: 0 2px 15px rgba(144, 205, 244, 0.4);
    }
    
    /* TBD placeholder styling */
    .tbd-placeholder {
        background: linear-gradient(135deg, rgba(255,255,255,0.1), rgba(255,255,255,0.05));
        border: 2px dashed #4a5568;
        transition: all 0.3s ease;
    }
    
    .tbd-placeholder:hover {
        border-color: #718096;
        background: linear-gradient(135deg, rgba(255,255,255,0.15), rgba(255,255,255,0.08));
    }
    
    /* Responsive enhancements */
    @media (max-width: 768px) {
        .vs-separator {
            font-size: 2rem;
        }
        
        .score-number {
            font-size: 3rem;
        }
        
        .tournament-header {
            padding: 1.5rem;
            margin-bottom: 2rem;
        }
    }
</style>

<!-- Header spacing div -->
<div style="height: 2rem;"></div>

<section class="pageheader-section" style="background-image: url({{ asset('images/pageheader/bg.jpg') }});">
    <div class="container mx-auto px-4 py-8 text-white">
        
        {{-- Enhanced Tournament Header --}}
        <div class="tournament-header text-center">
            <span class="text-gray-300 text-sm font-medium uppercase tracking-wider">Torneio</span>
            <h1 class="text-4xl font-bold mt-2">
                <a href="{{ route('tournaments.show', $match->tournament_id) }}" class="tournament-title transition-all duration-300">
                    {{ $match->tournament->name }}
                </a>
            </h1>
            <p class="text-xl text-gray-300 mt-3 font-medium">Rodada: {{ $match->round_number }}</p>
        </div>

        {{-- Enhanced Match Card --}}
        <div class="match-card max-w-5xl mx-auto p-8 md:p-10 rounded-2xl">
            <div>
                    <span class="text-m text-white font-mono">
                        ID: {{ $match->id }}
                    </span>
                </div>
            {{-- Versus Section --}}
            <div class="flex justify-around items-center">

                {{-- Team 1 --}}
                <div class="team-card text-center w-1/3 {{ ($match->winner_id && $match->winner_id != $match->team1_id) ? 'loser' : '' }} {{ $match->winner_id == $match->team1_id ? 'winner' : '' }}">
                    @if($match->team1)
                        <a href="{{ route('teams.show', $match->team1_id) }}" class="block">
                            <img src="{{ $match->team1->picture ? asset('images/team_pictures/' . $match->team1->picture) : asset('images/default-team-logo.png') }}" 
                                 alt="Logo {{ $match->team1->name }}" 
                                 class="team-logo w-28 h-28 md:w-36 md:h-36 rounded-full mx-auto border-4 border-gray-500 object-cover mb-4">
                            <h2 class="team-name text-xl md:text-2xl">{{ \Illuminate\Support\Str::limit($match->team1->name, 16) }}</h2>
                        </a>
                    @else
                        <div class="tbd-placeholder w-28 h-28 md:w-36 md:h-36 rounded-full mx-auto flex items-center justify-center mb-4">
                            <span class="text-gray-400 font-semibold">TBD</span>
                        </div>
                        <h2 class="text-xl md:text-2xl font-semibold text-gray-400">Aguardando</h2>
                    @endif
                </div>

                {{-- Enhanced Score and Status --}}
                <div class="text-center w-1/3">
                    <div class="score-display">
                        <div class="text-5xl md:text-7xl font-bold mb-3">
                            <span class="score-number">{{ $match->team1_score ?? 0 }}</span>
                            <span class="vs-separator mx-3">-</span>
                            <span class="score-number">{{ $match->team2_score ?? 0 }}</span>
                        </div>
                        @php
                            $statusText = 'Pendente';
                            $statusClass = 'status-pending';
                            if ($match->status === 'live') {
                                $statusText = 'Ao Vivo';
                                $statusClass = 'status-live';
                            } elseif ($match->status === 'completed') {
                                $statusText = 'Finalizada';
                                $statusClass = 'status-completed';
                            }
                        @endphp
                        <span class="status-badge {{ $statusClass }}">
                            {{ $statusText }}
                        </span>
                    </div>
                </div>

                {{-- Team 2 --}}
                <div class="team-card text-center w-1/3 {{ ($match->winner_id && $match->winner_id != $match->team2_id) ? 'loser' : '' }} {{ $match->winner_id == $match->team2_id ? 'winner' : '' }}">
                    @if($match->team2)
                        <a href="{{ route('teams.show', $match->team2_id) }}" class="block">
                             <img src="{{ $match->team2->picture ? asset('images/team_pictures/' . $match->team2->picture) : asset('images/default-team-logo.png') }}" 
                                  alt="Logo {{ $match->team2->name }}" 
                                  class="team-logo w-28 h-28 md:w-36 md:h-36 rounded-full mx-auto border-4 border-gray-500 object-cover mb-4">
                            <h2 class="team-name text-xl md:text-2xl">{{ \Illuminate\Support\Str::limit($match->team2->name, 16) }}</h2>
                        </a>
                    @else
                        <div class="tbd-placeholder w-28 h-28 md:w-36 md:h-36 rounded-full mx-auto flex items-center justify-center mb-4">
                            <span class="text-gray-400 font-semibold">TBD</span>
                        </div>
                        <h2 class="text-xl md:text-2xl font-semibold text-gray-400">Aguardando</h2>
                    @endif
                </div>
            </div>
        </div>

        {{-- Enhanced Admin Panel --}}
        @auth
            @if(Auth::user()->isAdmin())
            <div class="max-w-3xl mx-auto admin-panel p-8 rounded-2xl mt-10">
                <h3 class="text-2xl font-bold mb-6 text-white text-center">Painel do Admin: Declarar Vencedor</h3>
                @if(($match->status === 'pending' || $match->status === 'live') && $match->team1 && $match->team2)
                    <form action="{{ route('matches.setWinner', $match->id) }}" method="POST" class="admin-form">
                        @csrf
                        <div class="flex items-center justify-around mb-8">
                            <div class="text-center p-6 rounded-xl bg-gradient-to-b from-gray-700/50 to-gray-800/50 backdrop-blur-sm">
                                <label for="winner-{{$match->team1_id}}" class="block font-bold text-xl mb-4 cursor-pointer text-white">{{ \Illuminate\Support\Str::limit($match->team1->name, 16) }}</label>
                                <input type="radio" name="winner_id" id="winner-{{$match->team1_id}}" value="{{ $match->team1_id }}" required>
                            </div>
                            <div class="text-center p-6 rounded-xl bg-gradient-to-b from-gray-700/50 to-gray-800/50 backdrop-blur-sm">
                                <label for="winner-{{$match->team2_id}}" class="block font-bold text-xl mb-4 cursor-pointer text-white">{{ \Illuminate\Support\Str::limit($match->team2->name, 16) }}</label>
                                <input type="radio" name="winner_id" id="winner-{{$match->team2_id}}" value="{{ $match->team2_id }}" required>
                            </div>
                        </div>
                        <button type="submit" class="admin-submit-btn w-full text-white font-bold py-4 px-6 rounded-xl text-lg">
                            Confirmar Vencedor e Avançar
                        </button>
                    </form>
                @else
                    <p class="text-center text-gray-300 text-lg bg-gradient-to-r from-gray-700/50 to-gray-600/50 p-6 rounded-xl backdrop-blur-sm">Esta partida já foi finalizada ou não tem oponentes definidos.</p>
                @endif
            </div>
            @endif
        @endauth
    </div>
</section>

<!-- Footer spacing div -->
<div style="height: 3rem;"></div>

@endsection