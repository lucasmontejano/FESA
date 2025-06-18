@extends('layouts.app')

@section('title', 'Torneio: ' . $tournament->name)

@section('content')

    <style>
        [x-cloak] {
        display: none !important;
    }
    </style>

    <section class="pageheader-section" style="background-image: url(images/pageheader/bg.jpg);">
        <div class="container mx-auto py-8">
            <!-- Tournament Header -->
            <div class="flex flex-col md:flex-row gap-6 mb-8">
                <!-- Tournament Banner -->
                <div class="md:w-2/3">
                    @if($tournament->banner)
                        <div class="w-full h-96 overflow-hidden rounded-lg"> <!-- Changed rounded-t-lg to rounded-lg -->
                            <img src="{{ asset('images/tournament_banners/' . basename($tournament->banner)) }}" 
                                alt="{{ $tournament->name }} Banner"
                                class="w-full h-full object-cover">
                        </div>
                    @endif
                </div>
                
                <!-- Tournament Info -->
                <div class="md:w-1/3 bg-gray-800 p-6 rounded-lg">
                    <h1 class="text-2xl font-bold text-white mb-4" title="{{ $tournament->name }}">
                        {{ \Illuminate\Support\Str::limit($tournament->name, 30) }}
                    </h1>
                    
                    <div class="space-y-4 text-gray-300">
                        <div class="flex items-center">
                            <i class="icofont-game-pad mr-2"></i>
                            <span>{{ $tournament->game }}</span>
                        </div>
                        
                        <div class="flex items-center">
                            <i class="icofont-group mr-2"></i>
                            <span>{{ $participants_count }}/{{ $tournament->max_participants }} participantes</span>
                        </div>
                        <div class="flex items-center">
                            <i class="icofont-group mr-2"></i>
                            <span>Dia: {{ \Carbon\Carbon::parse($tournament->tournament_date)->format('d/m/Y') }}</span>
                        </div>

                        <div class="flex items-center">
                            <i class="icofont-group mr-2"></i>
                            <span>Horário: {{ substr($tournament->time, 0, 5 )}}</span>
                        </div>           
                        
                        @auth

                    @if ($ledTeams->isEmpty())
                        <a href="{{ route('teams.create', ['redirectTo' => url()->current()]) }}" class="block bg-orange-500 hover:bg-orange-600 text-white text-center py-2 px-4 rounded-lg mt-4">
                            Você precisa criar uma equipe primeiro!
                        </a>
                    @elseif ($subscribedLedTeam)
                        <form action="{{ route('tournaments.unsubscribeTeam', ['tournament' => $tournament->id, 'team' => $subscribedLedTeam->id]) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja cancelar a inscrição da equipe {{ $subscribedLedTeam->name }}?');">
                            @csrf
                            @method('DELETE') {{-- Or POST if you prefer, adjust route accordingly --}}
                            <button type="submit" class="block w-full bg-red-600 hover:bg-red-700 text-white text-center py-2 rounded-lg mt-4">
                                Cancelar Inscrição ({{ \Illuminate\Support\Str::limit($subscribedLedTeam->name, 16) }})
                            </button>
                        </form>
                    @else
                @php
                    $nowInSaoPaulo = \Carbon\Carbon::now('America/Sao_Paulo');
                    $isRegistrationOpen = $nowInSaoPaulo->lt($tournament->time);
                @endphp

                @if ($isRegistrationOpen && $tournament->status === 'registration_open')
                    @if ($ledTeams->count() === 1)
                        @php $teamToSubscribe = $ledTeams->first(); @endphp
                        <form action="{{ route('tournaments.subscribeTeam', $tournament->id) }}" method="POST">
                            @csrf
                            <input type="hidden" name="team_id" value="{{ $teamToSubscribe->id }}">
                            <button type="submit" class="block w-full bg-blue-600 hover:bg-blue-700 text-white text-center py-2 rounded-lg mt-4">
                                Inscrever Equipe ({{ $teamToSubscribe->name }})
                            </button>
                        </form>
                    @else
                        {{-- User leads multiple teams, provide a selection modal --}}
                        <button type="button" id="openSubscribeModalBtn" class="block w-full bg-blue-600 hover:bg-blue-700 text-white text-center py-2 rounded-lg mt-4">
                            Inscrever Equipe...
                        </button>

                        {{-- The modal itself is also inside this conditional, so it won't appear at all if registrations are closed --}}
                        <div id="subscribeTeamModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full flex items-center justify-center" style="display:none; z-index: 1050;">
                            <div class="relative mx-auto p-5 border w-full max-w-md shadow-lg rounded-md bg-white">
                                <div class="mt-3 text-center">
                                    <h3 class="text-lg leading-6 font-medium text-gray-900">Selecione sua equipe para inscrever</h3>
                                    <form action="{{ route('tournaments.subscribeTeam', $tournament->id) }}" method="POST" class="mt-2">
                                        @csrf
                                        <div class="mt-2 px-7 py-3">
                                            <select name="team_id" class="block w-full mt-1 p-2 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-black">
                                                @foreach ($ledTeams as $team)
                                                    <option value="{{ $team->id }}">{{ $team->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="items-center px-4 py-3">
                                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white text-base font-medium rounded-md w-auto shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-300">
                                                Confirmar Inscrição
                                            </button>
                                            <button type="button" id="closeSubscribeModalBtn" class="ml-2 px-4 py-2 bg-gray-300 text-gray-700 text-base font-medium rounded-md w-auto shadow-sm hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-300">
                                                Cancelar
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endif

                    <script>
                        // Ensure this script runs after the elements are in the DOM
                        document.addEventListener('DOMContentLoaded', function () {
                            const openModalBtn = document.getElementById('openSubscribeModalBtn');
                            const closeModalBtn = document.getElementById('closeSubscribeModalBtn');
                            const modal = document.getElementById('subscribeTeamModal');

                            if (openModalBtn && modal) {
                                openModalBtn.addEventListener('click', function() {
                                    modal.style.display = 'flex';
                                });
                            }

                            if (closeModalBtn && modal) {
                                closeModalBtn.addEventListener('click', function() {
                                    modal.style.display = 'none';
                                });
                            }

                            // Optional: Close modal if clicked outside of the modal content
                            if (modal) {
                                window.addEventListener('click', function(event) {
                                    if (event.target === modal) {
                                        modal.style.display = 'none';
                                    }
                                });
                            }
                        });
                    </script>
                @endif
            @endif
            @else
                {{-- User not authenticated --}}
                <a href="{{ route('login') }}" class="block bg-gray-400 hover:bg-gray-500 text-white text-center py-2 rounded-lg mt-4">
                    Faça login para se inscrever
                </a>
            @endauth
                        @if (auth()->check() && auth()->id() === $tournament->user_id)
                            <div x-data="{ editing: false }">  <div class="flex justify-end mb-4 space-x-2">
                                    <button @click="editing = true"
                                            class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                                        Editar Torneio
                                    </button>

                                    <form action="{{ route('tournaments.destroy', $tournament) }}" method="POST"
                                        onsubmit="return confirm('Tem certeza que deseja excluir este torneio?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 transition">
                                            Excluir Torneio
                                        </button>
                                    </form>
                                </div>

                                <div x-show="editing" x-cloak class="fixed inset-0 z-50 bg-black bg-opacity-70 flex items-center justify-center px-4 py-6">
                                    <div class="bg-gray-900 text-white rounded-lg shadow-lg p-6 w-full max-w-3xl max-h-full overflow-y-auto">
                                        <div class="flex justify-between items-center mb-4">
                                            <h2 class="text-xl font-bold">Editar Torneio</h2>
                                            <button @click="editing = false" class="text-gray-400 hover:text-gray-200">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                            </button>
                                        </div>

                                        <form action="{{ route('tournaments.update', $tournament) }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')

                                            <div class="space-y-4">
                                                <div>
                                                    <label for="name" class="block mb-1">Nome do Torneio</label>
                                                    <input type="text" id="name" name="name" value="{{ old('name', $tournament->name) }}"
                                                        class="w-full rounded bg-gray-800 border border-gray-700 px-3 py-2 text-white focus:border-blue-500 focus:ring-blue-500">
                                                </div>

                                                <div>
                                                    <label for="description" class="block mb-1">Descrição</label>
                                                    <textarea id="description" name="description" rows="3"
                                                            class="w-full rounded bg-gray-800 border border-gray-700 px-3 py-2 text-white focus:border-blue-500 focus:ring-blue-500">{{ old('description', $tournament->description) }}</textarea>
                                                </div>

                                                <div>
                                                    <label for="rules" class="block mb-1">Regras</label>
                                                    <textarea id="rules" name="rules" rows="4"
                                                            class="w-full rounded bg-gray-800 border border-gray-700 px-3 py-2 text-white focus:border-blue-500 focus:ring-blue-500">{{ old('rules', $tournament->rules) }}</textarea>
                                                </div>

                                                <div>
                                                    <label for="prizes" class="block mb-1">Premiação</label>
                                                    <textarea id="prizes" name="prizes" rows="3"
                                                            class="w-full rounded bg-gray-800 border border-gray-700 px-3 py-2 text-white focus:border-blue-500 focus:ring-blue-500">{{ old('prizes', $tournament->prizes) }}</textarea>
                                                </div>

                                                <div>
                                                    <label class="block mb-1">Banner atual:</label>
                                                    @if ($tournament->banner)
                                                        <div class="w-full h-96 overflow-hidden rounded-lg">
                                                            <img src="{{ asset('images/tournament_banners/' . basename($tournament->banner)) }}" 
                                                                alt="{{ $tournament->name }} Banner"
                                                                class="w-full h-full object-cover">
                                                        </div>
                                                    @else
                                                        <p class="text-sm text-gray-400 mb-2">Nenhum banner atual.</p>
                                                    @endif
                                                    <label class="block mb-1">Novo banner:</label>
                                                    <img id="bannerPreview" src="#" alt="Pré-visualização do novo banner" class="mt-2 mb-2 rounded max-h-96 object-cover w-full" style="display: none;">
                                                    <label class="block cursor-pointer w-full">
                                                        <input type="file" name="banner" class="hidden"
                                                            onchange="
                                                                const bannerPreview = document.getElementById('bannerPreview');
                                                                const currentBanner = document.getElementById('currentBanner');
                                                                if (this.files && this.files[0]) {
                                                                    bannerPreview.src = window.URL.createObjectURL(this.files[0]);
                                                                    bannerPreview.style.display = 'block';
                                                                    if (currentBanner) { currentBanner.style.display = 'none'; }
                                                                } else {
                                                                    bannerPreview.style.display = 'none';
                                                                    if (currentBanner) { currentBanner.style.display = 'block'; }
                                                                }
                                                            ">
                                                        <div class="border border-gray-700 rounded p-2 w-full text-center bg-gray-800 hover:bg-gray-700 transition">Clique para trocar a imagem</div>
                                                    </label>
                                                </div>
                                            </div>

                                            <div class="mt-6 flex flex-col sm:flex-row justify-between space-y-2 sm:space-y-0 sm:space-x-2">
                                                <button type="button" @click="editing = false"
                                                        class="w-full sm:w-auto px-4 py-2 bg-gray-700 rounded hover:bg-gray-600 transition">
                                                    Cancelar
                                                </button>
                                                <button type="submit"
                                                        class="w-full sm:w-auto px-4 py-2 bg-green-600 rounded hover:bg-green-700 transition">
                                                    Salvar Alterações
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Tabs Wrapper -->
    <div x-data="{ tab: 'details' }" class="bg-gray-900 p-6 rounded-lg">

        <!-- Tabs Buttons -->
        <div class="flex border-b border-gray-700 mb-6 space-x-4">
            <button @click="tab = 'details'" :class="tab === 'details' ? 'border-b-2 border-white text-white' : 'text-gray-400'" class="pb-2 px-4 focus:outline-none">
                DETALHES
            </button>
            <button @click="tab = 'description'" :class="tab === 'description' ? 'border-b-2 border-white text-white' : 'text-gray-400'" class="pb-2 px-4 focus:outline-none">
                DESCRIÇÃO
            </button>
            <button @click="tab = 'rules'" :class="tab === 'rules' ? 'border-b-2 border-white text-white' : 'text-gray-400'" class="pb-2 px-4 focus:outline-none">
                REGRAS
            </button>
            <button @click="tab = 'prizes'" :class="tab === 'prizes' ? 'border-b-2 border-white text-white' : 'text-gray-400'" class="pb-2 px-4 focus:outline-none">
                PREMIAÇÕES
            </button>
            <button @click="tab = 'contact'" :class="tab === 'contact' ? 'border-b-2 border-white text-white' : 'text-gray-400'" class="pb-2 px-4 focus:outline-none">
                DÚVIDAS
            </button>
            <button @click="tab = 'teams'" :class="tab === 'teams' ? 'border-b-2 border-white text-white' : 'text-gray-400'" class="pb-2 px-4 focus:outline-none">
                TIMES INSCRITOS
            </button>
        </div>

        <!-- Tab Contents -->
        <div x-show="tab === 'details'" class="text-gray-300 space-y-4">
            <h2 class="text-xl font-bold text-white">Jogo</h2>
            <p>{{ $tournament->game }}</p>

            <h2 class="text-xl font-bold text-white mt-6">Formato</h2>
            <p>{{ $tournament->format }}</p>
            <p>Times formados de 5 integrantes</p>

            <h2 class="text-xl font-bold text-white mt-6">Horário</h2>
            <p> 
                Dia: {{ \Carbon\Carbon::parse($tournament->tournament_date)->format('d/m/Y') }} <br> 
                Hora: {{ substr($tournament->time, 0, 5 )}}
            </p>
        </div>

        <div x-show="tab === 'description'" x-cloak class="text-gray-300 space-y-4">
            <h2 class="text-xl font-bold text-white mb-2">Descrição</h2>
            <div class="prose prose-invert max-w-none whitespace-normal break-words">
                {!! nl2br(e($tournament->description)) !!}
            </div>
        </div>

        <div x-show="tab === 'rules'" x-cloak class="text-gray-300 space-y-4">
            <h2 class="text-xl font-bold text-white mb-2">Regras</h2>
            <div class="prose prose-invert max-w-none whitespace-normal break-words">
                {!! nl2br(e($tournament->rules)) !!}
            </div>
        </div>

        <div x-show="tab === 'prizes'" x-cloak class="text-gray-300 space-y-4">
            <h2 class="text-xl font-bold text-white mb-2">Premiação</h2>
            <div class="prose prose-invert max-w-none whitespace-normal break-words">
                {!! nl2br(e($tournament->prizes)) !!}
            </div>
        </div>

        <div x-show="tab === 'contact'" x-cloak class="text-gray-300">
            <p>Para mais informações, entre em contato com a organização do evento pelo e-mail.</p>
        </div>

        <div x-show="tab === 'teams'" x-cloak>
                <h2 class="text-2xl font-semibold text-white mb-4">Equipes Inscritas</h2>
                @if ($tournament->teams && $tournament->teams->isNotEmpty())
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                        @foreach ($tournament->teams as $team)
                            <div class="bg-gray-800 p-4 rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-300 ease-in-out flex flex-col items-center text-center">
                                <img class="w-24 h-24 rounded-full mb-3 border-2 border-gray-600 object-cover"
                                     src="{{ $team->picture ? asset('images/team_pictures/' . $team->picture) : asset('images/default-team-logo.png') }}"
                                     alt="Logo {{ $team->name }}">
                                <h4 class="text-lg font-semibold text-white mb-2 flex-grow">
                                    <a href="{{ route('teams.show', $team->id) }}" class="hover:text-blue-400 transition-colors duration-200">
                                        {{ \Illuminate\Support\Str::limit($team->name, 20) }}
                                    </a>
                                </h4>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-400 text-center py-5">Nenhuma equipe inscrita neste torneio ainda.</p>
                @endif
            </div>

    </div>
    </section>

    @if($tournament->status === 'registration_open')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Função que verifica o status do torneio
    const checkTournamentStatus = async () => {
        try {
            // Chama a rota na web.php para obter o status
            const response = await fetch(`/tournaments/{{ $tournament->id }}/status`);
            
            if (!response.ok) {
                console.error('Erro ao buscar status do torneio. Verificação interrompida.');
                clearInterval(pollingInterval); // Para a verificação se houver um erro de rede
                return;
            }
            
            const data = await response.json();
            
            // Este log deve aparecer a cada 10 segundos no seu console
            console.log('Verificando... Status atual do torneio:', data.status);

            // Se o status mudou para 'live' (ou outro estado ativo), recarrega a página!
            if (data.status === 'live' || data.status === 'generating_matches') {
                console.log('O torneio começou! Redirecionando para o bracket...');
                clearInterval(pollingInterval); // Para a verificação antes de redirecionar
                window.location.reload(); // Recarrega a página
            }

        } catch (error) {
            console.error('Falha na requisição de polling. Verificação interrompida.', error);
            clearInterval(pollingInterval); // Para a verificação se houver um erro de script
        }
    };

    // Inicia a verificação periódica a cada 10 segundos (10000 milissegundos)
    const pollingInterval = setInterval(checkTournamentStatus, 10000);
});
</script>
@endif
@endsection