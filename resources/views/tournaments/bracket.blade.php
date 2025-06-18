@extends('layouts.app')

@section('title', 'Bracket: ' . $tournament->name)

@push('styles')
<style>
    .bracket-container { display: flex; overflow-x: auto; background-color: #161824; padding: 20px; border-radius: 8px; }
    .bracket-container::-webkit-scrollbar { height: 10px; }
    .bracket-container::-webkit-scrollbar-track { background: #1f2333; border-radius: 10px; }
    .bracket-container::-webkit-scrollbar-thumb { background-color: #4a5568; border-radius: 10px; border: 2px solid #1f2333; }
    .bracket-flow { display: flex; gap: 40px; min-width: fit-content; }
    .round-column { display: flex; flex-direction: column; justify-content: space-around; flex-shrink: 0; min-width: 280px; position: relative; }
    .round-title { color: #e0e0e0; font-size: 1.5em; font-weight: 600; text-align: center; margin-bottom: 2rem; }
    .matches-list { display: flex; flex-direction: column; justify-content: space-around; flex-grow: 1; gap: 20px; }
    .match-box { background-color: #1f2333; border: 1px solid #3a3f5a; border-left: 4px solid #4a5568; padding: 15px; border-radius: 6px; color: #c7d2fe; position: relative; }
    .match-box.match-live { border-left-color: #facc15; }
    .team { display: flex; justify-content: space-between; align-items: center; }
    .team.winner span:first-child { color: #68d391; font-weight: bold; }
    .team.loser span:first-child { text-decoration: line-through; opacity: 0.6; }
    .team .score { font-weight: bold; min-width: 20px; text-align: right; }
    .match-details-link { display: block; margin-top: 10px; text-align: right; font-size: 0.8em; color: #60a5fa; text-decoration: none; }
    .match-details-link:hover { text-decoration: underline; }
    .champion-box { background: linear-gradient(145deg, #a8850a, #e5be37, #a8850a); padding: 20px; border-radius: 8px; text-align: center; color: #1a202c; box-shadow: 0 10px 25px rgba(255, 215, 0, 0.3); border: 2px solid #fff; }
    .champion-box img { width: 100px; height: 100px; border-radius: 50%; border: 4px solid #fff; margin: 0 auto 15px auto; object-fit: cover; }
    .champion-box .trophy-icon { font-size: 2rem; color: #fff; text-shadow: 0 2px 4px rgba(0,0,0,0.3); }
    .champion-box .champion-name { font-size: 1.75em; font-weight: 800; margin: 0; }
</style>
@endpush

@section('content')
<section class="pageheader-section" style="background-image: url({{ asset('images/pageheader/bg.jpg') }});">
    <div class="container mx-auto px-4 py-8 text-white">

        <div class="bg-gray-900 border border-gray-900 rounded-xl shadow-lg p-6 md:p-8 mb-8">
    <div class="flex flex-col md:flex-row justify-center items-center gap-8">
        
        {{-- Banner do Torneio (sem alterações) --}}
        @if($tournament->banner)
            <img src="{{ asset('images/tournament_banners/' . basename($tournament->banner)) }}"
                 alt="Banner do Torneio"
                 class="w-full md:w-[640px] h-auto md:h-[340px] object-cover rounded-lg shadow-lg border-2 border-gray-600 flex-shrink-0">
        @endif

        {{-- Informações do Torneio e do Campeão (sem alterações) --}}
        <div class="flex-1 max-w-2xl text-center md:text-left">
            <h1 class="text-4xl md:text-5xl font-bold mb-3">{{ $tournament->name }}</h1>
            <p class="text-xl md:text-2xl text-yellow-400">Status: {{ ucfirst(str_replace('_', ' ', $tournament->status)) }}</p>

            {{-- Seção do Campeão (já estava dentro e continua aqui) --}}
            @if ($tournament->status === 'completed' && $tournament->champion)
                <div class="max-w-md mx-auto md:mx-0 mt-6 p-4 bg-gray-900 border-2 border-yellow-500 rounded-lg shadow-2xl text-center">
                    <h3 class="text-lg font-bold text-yellow-300">🏆 EQUIPE CAMPEÃ 🏆</h3>
                    <a href="{{ route('teams.show', $tournament->champion->id) }}" class="group block mt-3 focus:outline-none focus:ring-2 focus:ring-yellow-200 rounded-lg">
                        <div class="flex flex-col items-center">
                            <img class="w-16 h-16 rounded-full border-4 border-white shadow-lg transition-transform duration-300 group-hover:scale-110"
                                 src="{{ $tournament->champion->picture ? asset('images/team_pictures/' . $tournament->champion->picture) : asset('images/default-team-logo.png') }}"
                                 alt="Logo {{ $tournament->champion->name }}">
                            
                            <p class="mt-3 text-2xl font-extrabold text-white transition-colors duration-300 group-hover:text-yellow-100" style="text-shadow: 1px 1px 3px rgba(0,0,0,0.5);">
                                {{ \Illuminate\Support\Str::limit($tournament->champion->name, 20) }}
                            </p>
                        </div>
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

        {{-- Contêiner do Bracket --}}
        <p style="font-size: 0.9em; color: #474747;">*BYE = Time que avança para a próxima rodada sem precisar jogar.</p>
        <div class="bracket-container" id="custom-bracket">
            @if($rounds->isEmpty())
                <p class="text-gray-400 text-center w-full py-10">O bracket ainda não foi gerado.</p>
            @else
                <div class="bracket-flow">
                    @foreach($rounds as $roundNumber => $matchupsInRound)
                        <div class="round-column">
                            <h3 class="round-title">Rodada {{ $roundNumber }}</h3>
                            <div class="matches-list">
                                @foreach($matchupsInRound as $match)
                                    <div class="match-box {{ $match->status === 'live' ? 'match-live' : '' }}">
                                        @php
                                            $team1_extra_class = ($match->winner_id == $match->team1_id) ? 'winner' : (($match->winner_id) ? 'loser' : '');
                                            $team2_extra_class = ($match->winner_id == $match->team2_id) ? 'winner' : (($match->winner_id) ? 'loser' : '');
                                        @endphp
                                        <div class="team {{ $team1_extra_class }}">
                                            <span>{{ $match->team1->name ?? 'N/A' }}</span>
                                            <span class="score">{{ $match->team1_score ?? '-' }}</span>
                                        </div>
                                        <div class="team {{ $team2_extra_class }}">
                                            <span>{{ $match->team2->name ?? 'N/A' }}</span>
                                            <span class="score">{{ $match->team2_score ?? '-' }}</span>
                                        </div>
                                        <div class="flex justify-between items-center mt-2 pt-2 border-t border-gray-700">
                                                
                                                {{-- ID da Partida (Esquerda) - pequeno e com cor sutil --}}
                                                <span class="text-xs text-gray-500 font-mono">
                                                    ID: {{ $match->id }}
                                                </span>

                                                {{-- Link/Texto de Bye (Direita) --}}
                                                <div>
                                                    @if($match->team1_id && $match->team2_id)
                                                        <a href="{{ route('matches.show', $match->id) }}" class="match-details-link">
                                                            Gerenciar Partida
                                                        </a>
                                                    @elseif ($match->team1_id && !$match->team2_id)
                                                        <p class="text-xs text-gray-400 italic">{{$match->team1->name}} avançou (BYE)</p>
                                                    @endif
                                                </div>

                                            </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- Botão "Ir para Minha Partida" (permanece o mesmo) --}}
        @if($isParticipant ?? false)
        <div class="text-center mt-8 mb-6">
            @if(isset($currentUserTeamMatchId) && $currentUserTeamMatchId)
                <a href="{{ route('matches.show', $currentUserTeamMatchId) }}"
                class="bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-8 rounded-lg text-lg">
                    Ir para Minha Partida Atual
                </a>
            @else
                <p class="text-gray-400 text-lg">Sua equipe não tem uma partida pendente ou ativa no momento.</p>
            @endif
        </div>
        @endif

    </div>
</section>
@endsection

@push('scripts')
    {{-- Script opcional de redirecionamento após 5 minutos --}}
    @if(isset($currentUserTeamMatchId) && in_array($tournament->status, ['live', 'round_1_pending']))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Timer iniciado para redirecionar para a partida ID: {{ $currentUserTeamMatchId }} em 5 minutos.');
            setTimeout(function() {
                window.location.href = "{{ route('matches.show', ['match' => $currentUserTeamMatchId]) }}";
            }, 5 * 60 * 1000);
        });
    </script>
    @endif
@endpush