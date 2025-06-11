@extends('layouts.app')
@section('title', ($match->team1 ? $match->team1->name : 'Equipe A') . ' vs ' . ($match->team2 ? $match->team2->name : 'Equipe B'))
@section('content')
<style>
    /* Estilo customizado para o placar e o card da partida */
    .match-card {
        background: linear-gradient(145deg, #2d3748, #1a202c);
        border: 1px solid #4a5568;
        box-shadow: 0 10px 20px rgba(0,0,0,0.25);
    }
    .team-card {
        transition: transform 0.3s ease, opacity 0.3s ease;
    }
    .team-card.loser {
        opacity: 0.5;
        transform: scale(0.95);
    }
    .team-card.winner .team-logo {
        border-color: #68d391; /* Borda verde para o vencedor */
    }
    .vs-separator {
        color: #4a5568;
        font-weight: 800;
        font-size: 2.5rem;
        line-height: 1;
    }
    /* Estilos para os botões de rádio do admin */
    .admin-form input[type="radio"] {
        appearance: none;
        -webkit-appearance: none;
        width: 24px;
        height: 24px;
        border: 2px solid #9ca3af;
        border-radius: 50%;
        outline: none;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    .admin-form input[type="radio"]:hover {
        border-color: #60a5fa;
    }
    .admin-form input[type="radio"]:checked {
        border-color: #68d391;
        background-color: #68d391;
        box-shadow: 0 0 0 3px #1f2333, 0 0 0 5px #68d391;
    }
</style>
<section class="pageheader-section" style="background-image: url({{ asset('images/pageheader/bg.jpg') }});">
    <div class="container mx-auto px-4 py-8 text-white">
        
        {{-- Título do Torneio --}}
        <div class="text-center mb-6">
            <span class="text-gray-400">Torneio</span>
            <h1 class="text-3xl font-bold">
                <a href="{{ route('tournaments.show', $match->tournament_id) }}" class="text-blue-400 hover:text-blue-300 transition-colors">
                    {{ $match->tournament->name }}
                </a>
            </h1>
            <p class="text-lg text-gray-300">Rodada: {{ $match->round_number }}</p>
        </div>

        {{-- Card da Partida --}}
        <div class="match-card max-w-4xl mx-auto p-6 md:p-8 rounded-lg">
            
            {{-- Seção Versus --}}
            <div class="flex justify-around items-center">

                {{-- Time 1 --}}
                <div class="team-card text-center w-1/3 {{ ($match->winner_id && $match->winner_id != $match->team1_id) ? 'loser' : '' }} {{ $match->winner_id == $match->team1_id ? 'winner' : '' }}">
                    @if($match->team1)
                        <a href="{{ route('teams.show', $match->team1_id) }}">
                            <img src="{{ $match->team1->picture ? asset('images/team_pictures/' . $match->team1->picture) : asset('images/default-team-logo.png') }}" 
                                 alt="Logo {{ $match->team1->name }}" 
                                 class="team-logo w-24 h-24 md:w-32 md:h-32 rounded-full mx-auto border-4 border-gray-600 object-cover mb-3">
                            <h2 class="text-xl md:text-2xl font-semibold">{{ $match->team1->name }}</h2>
                        </a>
                    @else
                        <div class="w-24 h-24 md:w-32 md:h-32 rounded-full mx-auto border-4 border-dashed border-gray-600 flex items-center justify-center mb-3">
                            <span class="text-gray-500">TBD</span>
                        </div>
                        <h2 class="text-xl md:text-2xl font-semibold text-gray-500">Aguardando</h2>
                    @endif
                </div>

                {{-- Placar e Status --}}
                <div class="text-center w-1/3">
                    <div class="text-5xl md:text-6xl font-bold mb-2">
                        <span>{{ $match->team1_score ?? 0 }}</span>
                        <span class="vs-separator mx-2">-</span>
                        <span>{{ $match->team2_score ?? 0 }}</span>
                    </div>
                    @php
                        $statusText = 'Pendente';
                        $statusClass = 'bg-gray-500';
                        if ($match->status === 'live') {
                            $statusText = 'Ao Vivo';
                            $statusClass = 'bg-yellow-500 animate-pulse';
                        } elseif ($match->status === 'completed') {
                            $statusText = 'Finalizada';
                            $statusClass = 'bg-red-600';
                        }
                    @endphp
                    <span class="text-sm font-semibold px-3 py-1 rounded-full {{ $statusClass }}">
                        {{ $statusText }}
                    </span>
                </div>

                {{-- Time 2 --}}
                <div class="team-card text-center w-1/3 {{ ($match->winner_id && $match->winner_id != $match->team2_id) ? 'loser' : '' }} {{ $match->winner_id == $match->team2_id ? 'winner' : '' }}">
                    @if($match->team2)
                        <a href="{{ route('teams.show', $match->team2_id) }}">
                             <img src="{{ $match->team2->picture ? asset('images/team_pictures/' . $match->team2->picture) : asset('images/default-team-logo.png') }}" 
                                  alt="Logo {{ $match->team2->name }}" 
                                  class="team-logo w-24 h-24 md:w-32 md:h-32 rounded-full mx-auto border-4 border-gray-600 object-cover mb-3">
                            <h2 class="text-xl md:text-2xl font-semibold">{{ $match->team2->name }}</h2>
                        </a>
                    @else
                        <div class="w-24 h-24 md:w-32 md:h-32 rounded-full mx-auto border-4 border-dashed border-gray-600 flex items-center justify-center mb-3">
                            <span class="text-gray-500">TBD</span>
                        </div>
                        <h2 class="text-xl md:text-2xl font-semibold text-gray-500">Aguardando</h2>
                    @endif
                </div>

            </div>
        </div>

        {{-- Painel do Admin --}}
        @auth
            @if(Auth::user()->isAdmin())
            <div class="max-w-2xl mx-auto bg-gray-700 p-6 rounded-lg shadow-xl mt-8">
                <h3 class="text-xl font-semibold mb-4 text-white">Painel do Admin: Declarar Vencedor</h3>
                @if(($match->status === 'pending' || $match->status === 'live') && $match->team1 && $match->team2)
                    <form action="{{ route('matches.setWinner', $match->id) }}" method="POST" class="admin-form">
                        @csrf
                        <div class="flex items-center justify-around">
                            <div class="text-center">
                                <label for="winner-{{$match->team1_id}}" class="block font-bold text-lg mb-2 cursor-pointer">{{ $match->team1->name }}</label>
                                <input type="radio" name="winner_id" id="winner-{{$match->team1_id}}" value="{{ $match->team1_id }}" required>
                            </div>
                            <div class="text-center">
                                <label for="winner-{{$match->team2_id}}" class="block font-bold text-lg mb-2 cursor-pointer">{{ $match->team2->name }}</label>
                                <input type="radio" name="winner_id" id="winner-{{$match->team2_id}}" value="{{ $match->team2_id }}" required>
                            </div>
                        </div>
                        <button type="submit" class="w-full mt-6 bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-4 rounded-lg transition-transform transform hover:scale-105">
                            Confirmar Vencedor e Avançar
                        </button>
                    </form>
                @else
                    <p class="text-center text-gray-300">Esta partida já foi finalizada ou não tem oponentes definidos.</p>
                @endif
            </div>
            @endif
        @endauth
    </div>
</section>
@endsection