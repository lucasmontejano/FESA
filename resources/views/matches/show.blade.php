@extends('layouts.app')
@section('title', ($match->team1 ? $match->team1->name : 'Equipe A') . ' vs ' . ($match->team2 ? $match->team2->name : 'Equipe B'))
@section('content')
<div class="container mx-auto px-4 py-8 text-white">
    <h1 class="text-3xl font-bold text-center mb-2">
        Torneio: <a href="{{ route('tournaments.show', $match->tournament_id) }}" class="text-blue-400 hover:text-blue-300">{{ $match->tournament->name }}</a>
    </h1>
    <h2 class="text-4xl font-bold text-center mb-8">
        <span class="{{ $match->winner_id == $match->team1_id ? 'text-green-400' : '' }}">{{ $match->team1 ? $match->team1->name : 'Aguardando' }}</span>
        <span class="text-gray-500 mx-4">VS</span>
        <span class="{{ $match->winner_id == $match->team2_id ? 'text-green-400' : '' }}">{{ $match->team2 ? $match->team2->name : 'Aguardando' }}</span>
    </h2>
    <p class="text-center text-xl mb-2">Rodada: {{ $match->round_number }}</p>
    <p class="text-center text-lg mb-6">Status: {{ ucfirst($match->status) }}</p>

    {{-- Placeholder for match details, score reporting, chat, etc. --}}
    <div class="max-w-2xl mx-auto bg-gray-800 p-6 rounded-lg shadow-xl">
        <h3 class="text-xl font-semibold mb-4">Detalhes da Partida</h3>
        @if($match->status === 'pending')
            <p>Esta partida ainda não começou.</p>
        @elseif($match->status === 'live')
            <p>Esta partida está em andamento!</p>
        @elseif($match->status === 'completed' || $match->winner_id)
            <p>Partida concluída.</p>
            <p>Vencedor: {{ $match->winner ? $match->winner->name : 'Indefinido' }}</p>
            <p>Placar: {{ $match->team1_score ?? 'N/A' }} - {{ $match->team2_score ?? 'N/A' }}</p>
        @endif
        {{-- Add form for score reporting if user is a participant/captain --}}
    </div>
</div>
@endsection