@extends('layouts.app')

@section('title', 'Bracket: ' . $tournament->name)

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-white mb-2 text-center">{{ $tournament->name }}</h1>
    <p class="text-xl text-yellow-400 mb-6 text-center">Status: {{ ucfirst(str_replace('_', ' ', $tournament->status)) }}</p>

    {{-- Container for the JavaScript Bracket Library --}}
    <div id="bracket-container" class="bg-gray-800 p-2 md:p-6 rounded-lg shadow-xl">
        {{-- The JS library will render the bracket here --}}
        {{-- You might need some specific structure or styling based on the library --}}
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
@endsection

@push('styles')
{{-- Include CSS for your chosen bracket library if it's not globally included --}}
{{-- Example for brackets-viewer.js --}}
<link rel="stylesheet" href="https://unpkg.com/brackets-viewer@latest/dist/brackets-viewer.min.css" />
<style>
    /* Custom styles for the bracket container or library overrides */
    #bracket-container .round-title { color: white; margin-bottom: 10px; }
    #bracket-container .match-location { display: none; } /* Example: Hide default location text */
    #bracket-container .team { color: #e0e0e0; background-color: #374151; border-color: #4b5563; } /* Darker team boxes */
    #bracket-container .team.winner { color: #a7f3d0; border-color: #10b981; } /* Winner style */
    #bracket-container .score { color: white; }
    #bracket-container .connector { border-color: #4b5563; }
    #bracket-container .connector .connector { border-color: #4b5563; }
</style>
@endpush

@push('scripts')
{{-- Include JS for your chosen bracket library if it's not globally included --}}
{{-- Example for brackets-viewer.js --}}
<script src="https://unpkg.com/brackets-viewer@latest/dist/brackets-viewer.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const matchupsData = @json($formattedMatchups); // Get data from controller

    if (matchupsData && matchupsData.length > 0) {
        // This is a conceptual data transformation.
        // You NEED to adapt this to the specific format your chosen library requires.
        // The `brackets-viewer.js` library expects a specific structure often involving stages, groups, rounds, and matches.
        // For a simple single elimination, you might need to structure it like:
        const roundsForViewer = [];
        let currentRound = 1;
        let matchesInCurrentRound = [];

        // This is a very simplified data prep assuming single stage, single group.
        // You'll likely need to iterate through your $rounds collection from the controller
        // or process matchupsData more thoroughly.
        // The data structure below is a guess for brackets-viewer.js minimal data.
        // Please consult the library's documentation for the correct data structure.

        // Example: Constructing data for `brackets-viewer.js` (this is complex and needs care)
        // This requires knowing how many rounds total, team seeding, etc.
        // For a simple display, you might need to manually structure `stages`, `groups`, `rounds`, `matches`.
        // A more straightforward approach for simpler libraries is just a list of matches with IDs and participant names/scores.

        // Let's try a simpler conceptual example of initializing a generic library
        // Assuming a library that takes a flat list and figures out rounds:
        const bracketDataForSimpleLibrary = matchupsData.map(match => ({
            matchId: match.id,
            round: match.round_number,
            // teams: [
            //     { name: match.team1_name, score: match.team1_score, id: match.team1_id },
            //     { name: match.team2_name, score: match.team2_score, id: match.team2_id }
            // ],
            // winner_id: match.winner_id // If library supports highlighting winner
        }));
        
        // Placeholder for actual library initialization
        // console.log("Data prepared for bracket library:", bracketDataForSimpleLibrary);
        // For `brackets-viewer.js`, you would do something like:
        // window.bracketsViewer.render({
        //     stages: [...], // You need to build this structure
        //     matches: [...],
        //     participants: [...], // List of all unique teams
        //     tournament_type: 'single_elimination' // or 'double_elimination'
        // }, {
        //     selector: "#bracket-container",
        //     // ... other options
        // });
        // Due to complexity of data prep for brackets-viewer from flat list,
        // I'll add a placeholder message if no library is fully integrated.
        const bracketContainer = document.getElementById('bracket-container');
        if(bracketContainer) {
            if (typeof window.bracketsViewer !== 'undefined' && matchupsData.length > 0) {
                // You would need to transform `matchupsData` into the full complex structure
                // required by brackets-viewer.js, including stages, groups, participants lists etc.
                // This is non-trivial.
                // For now, let's just indicate what data is available.
                bracketContainer.innerHTML = `<pre class="text-white text-xs">${JSON.stringify(matchupsData, null, 2)}</pre><p class="text-yellow-400 mt-4">Integração com a biblioteca de brackets visuais (ex: brackets-viewer.js) precisa ser completada aqui, transformando os dados acima no formato esperado pela biblioteca.</p>`;
            } else if (matchupsData.length > 0) {
                bracketContainer.innerHTML = '<p class="text-yellow-400">Biblioteca de bracket visual não carregada, mas os dados das partidas estão disponíveis.</p>';
            } else {
                bracketContainer.innerHTML = '<p class="text-gray-400">Nenhum confronto gerado para este bracket ainda.</p>';
            }
        }

    } else {
         const bracketContainer = document.getElementById('bracket-container');
         if(bracketContainer) {
            bracketContainer.innerHTML = '<p class="text-gray-400">Nenhum confronto disponível para exibir o bracket.</p>';
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