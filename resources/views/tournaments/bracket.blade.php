@extends('layouts.app')

@section('title', 'Bracket: ' . $tournament->name)

@section('content')
<section class="pageheader-section" style="background-image: url(images/pageheader/bg.jpg);">
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-white mb-2 text-center">{{ $tournament->name }}</h1>
        <p class="text-xl text-yellow-400 mb-6 text-center">Status: {{ ucfirst(str_replace('_', ' ', $tournament->status)) }}</p>

        <div id="bracket-container" class="bg-gray-800 p-2 md:p-6 rounded-lg shadow-xl min-h-[400px] flex items-center justify-center">
            <p class="text-white text-xl">Carregando bracket...</p>
        </div>

        {{-- "Go to My Match" Button - Placed after the bracket container --}}
        @if($isParticipant)
        <div class="text-center mt-8 mb-6">
            @if(isset($currentUserTeamMatchId) && $currentUserTeamMatchId)
                <a href="{{ route('matches.show', $currentUserTeamMatchId) }}"
                class="bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-8 rounded-lg text-lg shadow-md hover:shadow-lg transition-all duration-300 ease-in-out transform hover:scale-105">
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
    <script>
    document.addEventListener('DOMContentLoaded', function() {

        const rawParticipantTeams = @json($participantTeamsForBracket ?? []);
        const tournamentNameForStage = @json($tournament->name ?? 'Torneio');
        const bracketContainer = document.getElementById('bracket-container');
        const rawMatchesData = @json($formattedMatchups ?? []);

        console.log("JS: Raw Participants Received:", typeof rawParticipantTeams !== 'undefined' ? rawParticipantTeams : 'rawParticipantTeams IS UNDEFINED');
        console.log("JS: Raw Matches Received:", typeof rawMatchesData !== 'undefined' ? rawMatchesData : 'rawMatchesData IS UNDEFINED');
        console.log("JS: Bracket Container Element:", bracketContainer);
        console.log("JS: Is bracketsViewer library loaded?", typeof window.bracketsViewer);

        if (!bracketContainer || typeof window.bracketsViewer === 'undefined') {
            console.error('Bracket container or bracketsViewer library not found.');
            if (bracketContainer) {
                bracketContainer.innerHTML = '<p class="text-red-500 text-center py-10">Erro: Biblioteca de brackets não carregada.</p>';
            }
            return;
        }

        if (rawParticipantTeams.length < 2 && rawMatchesData.length === 0) {
            bracketContainer.innerHTML = '<p class="text-gray-400 text-center py-10">Não há equipes ou confrontos suficientes para exibir o bracket.</p>';
            return;
        }
        if (rawMatchesData.length === 0) { // Separate check if participants exist but no matches
            bracketContainer.innerHTML = '<p class="text-gray-400 text-center py-10">Nenhum confronto gerado para este bracket ainda.</p>';
            return;
        }


        try {
            const participants = rawParticipantTeams.map(team => ({
                id: team.id.toString(), // Ensure ID is a string if library is strict
                name: team.name,
            }));

            const matchesForViewer = rawMatchesData.map(match => {
                let result1 = null; // Default to null for pending matches
                let result2 = null; // Default to null for pending matches

                if (match.winner_id) {
                    if (match.team1_id) { // Ensure team1_id exists before checking
                        result1 = (match.winner_id.toString() === match.team1_id.toString()) ? 'win' : 'loss';
                    }
                    if (match.team2_id) { // Ensure team2_id exists
                        result2 = (match.winner_id.toString() === match.team2_id.toString()) ? 'win' : 'loss';
                    }
                }

                // Explicitly handle BYEs if your backend sets winner_id for byes
                if (match.team1_id && !match.team2_id && match.winner_id && match.winner_id.toString() === match.team1_id.toString()) {
                    result1 = 'win'; // Team1 wins by bye
                }
                if (match.team2_id && !match.team1_id && match.winner_id && match.winner_id.toString() === match.team2_id.toString()) {
                    result2 = 'win'; // Team2 wins by bye
                }

                return {
                    id: match.id,
                    stage_id: 0,
                    group_id: 0,
                    round_id: match.round_number - 1, // Assuming 0-indexed for library

                    opponent1: match.team1_id ? {
                        id: match.team1_id.toString(),
                        score: match.team1_score,
                        result: result1 // <<<< Ensure 'result' key is always present
                    } : null,

                    opponent2: match.team2_id ? {
                        id: match.team2_id.toString(),
                        score: match.team2_score,
                        result: result2 // <<<< Ensure 'result' key is always present
                    } : null,
                };
            });

            const viewerData = {
                participants: participants,
                stages: [
                    {
                        id: 0,
                        name: @json($tournament->name ?? 'Torneio'),
                        type: 'single_elimination',
                        settings: {
                            seedOrdering: ['natural'],
                            balanceByes: false // Adjust if your backend doesn't pre-determine byes
                        }
                    }
                ],
                matches: matchesForViewer,
            };

            console.log("Data being sent to bracketsViewer.render (with results):", JSON.stringify(viewerData, null, 2));

            window.bracketsViewer.render(viewerData, {
                selector: "#bracket-container",
                showSlotsOrigin: true,
                highlightParticipantOnHover: true,
                // ... other options
            });
            console.log("JS: bracketsViewer.render() called.");


        } catch (error) {
            console.error("JS: Error preparing or rendering bracket:", error);
            if(bracketContainer) { // Check if bracketContainer is still defined in this scope
                bracketContainer.innerHTML = '<p class="text-red-500 text-center py-10">Ocorreu um erro ao gerar o bracket. Verifique o console.</p>';
            }
        }

        // Your 5-minute timer logic (if you keep it)
        @if(isset($currentUserTeamMatchId) && $currentUserTeamMatchId && in_array($tournament->status, ['live', 'round_1_pending']))
            // console.log('Timer (still active if uncommented) for redirect to match ID: {{ $currentUserTeamMatchId }} (5 min)');
            // setTimeout(function() {
            //     window.location.href = "{{ route('matches.show', ['match' => $currentUserTeamMatchId]) }}";
            // }, 5 * 60 * 1000);
        @endif
    });
    </script>
@endpush