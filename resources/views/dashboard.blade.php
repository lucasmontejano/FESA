@extends('layouts.app')

@section('title', 'Torneios')

@section('content')
    <!-- ===========Banner Section start Here========== -->
    <section class="pageheader-section" style="background-image: url(images/pageheader/bg.jpg);">
        
            <div class="container mx-auto py-12 px-4">
                <!-- Main Content Area - Full Width -->
                <div class="w-full">
                    <!-- Tournaments Header -->
                    <div class="mb-8">
                        <h1 class="text-4xl font-bold text-white mb-6">Torneios</h1>
                        
                        <!-- Filter Options -->
                        <div class="flex flex-wrap gap-3">
                            @php
                            // Define o status padrão como 'upcoming' se nenhum for passado na URL
                            $currentStatus = request('status', 'upcoming');
                            @endphp

                    <div class="relative group" x-data="{ open: false }">
                        <button @click="open = !open" class="bg-gray-800 hover:bg-gray-700 text-white px-6 py-3 rounded-md flex items-center">
                            <span>{{ request('game') ? 'Jogo: ' . request('game') : 'Filtrar por Jogo' }}</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                        </button>
                        
                        <div x-show="open" @click.away="open = false" x-cloak
                            class="absolute z-10 mt-1 w-56 bg-gray-800 rounded-md shadow-lg border border-gray-700">
                            <div class="py-1">
                                <a href="{{ route('dashboard', ['status' => request('status', 'upcoming')]) }}" class="flex items-center px-4 py-2 text-sm text-gray-300 hover:bg-gray-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" /></svg>
                                    Todos os Jogos
                                </a>

                                @foreach($games as $game)
                                    <a href="{{ route('dashboard', ['status' => request('status', 'upcoming'), 'game' => $game]) }}" class="flex items-center px-4 py-2 text-sm text-gray-300 hover:bg-gray-700">
                                        {{ $game }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    @foreach($games as $game)
                    @php
                        $isActive = request('game') == $game;
                    @endphp
                    
                    <a href="
                              {{ $isActive 
                                    ? route('dashboard', ['status' => request('status', 'upcoming')]) 
                                    : route('dashboard', ['status' => request('status', 'upcoming'), 'game' => $game]) 
                              }}" 
                       class="flex items-center px-4 py-2 text-sm rounded-md transition-colors duration-200
                              {{ $isActive ? 'bg-blue-600/30 text-white ring-2 ring-blue-500' : 'text-gray-300 hover:bg-gray-700' }}">
                        
                        @if(strcasecmp($game, 'CS2') === 0)
                            <img src="https://upload.wikimedia.org/wikipedia/commons/9/9c/Counter_Strike_2_Logo.png" alt="CS2" class="w-5 h-5 mr-3">
                        @elseif(strcasecmp($game, 'League of Legends') === 0 || strcasecmp($game, 'LOL') === 0)
                            <img src="https://upload.wikimedia.org/wikipedia/commons/d/d8/League_of_Legends_2019_vector.svg" alt="LoL" class="w-5 h-5 mr-3">
                        @elseif(strcasecmp($game, 'VALORANT') === 0)
                             <img src="https://upload.wikimedia.org/wikipedia/commons/f/fc/Valorant_logo_-_pink_color_version.svg" alt="VALORANT" class="w-5 h-5 mr-3">
                        @else
                             <span class="w-5 h-5 mr-3"></span>
                        @endif
                        
                        {{ $game }}
                    </a>
                @endforeach

                    <div class="h-8 w-px bg-gray-700 mx-2"></div>
                    
                    <a href="{{ route('dashboard', ['status' => 'upcoming', 'game' => request('game')]) }}"
                    class="px-6 py-3 rounded-md flex items-center transition-colors duration-200
                            {{ $currentStatus === 'upcoming' ? 'bg-blue-600 text-white shadow-md' : 'bg-gray-800 text-gray-300 hover:bg-gray-700' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        Próximos
                    </a>

                    <a href="{{ route('dashboard', ['status' => 'completed', 'game' => request('game')]) }}"
                    class="px-6 py-3 rounded-md flex items-center transition-colors duration-200
                            {{ $currentStatus === 'completed' ? 'bg-blue-600 text-white shadow-md' : 'bg-gray-800 text-gray-300 hover:bg-gray-700' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        Finalizados
                    </a>

                    <a href="{{ route('dashboard', ['status' => 'all', 'game' => request('game')]) }}"
                    class="px-6 py-3 rounded-md flex items-center transition-colors duration-200
                            {{ $currentStatus === 'all' ? 'bg-blue-600 text-white shadow-md' : 'bg-gray-800 text-gray-300 hover:bg-gray-700' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" /></svg>
                        Todos
                    </a>
            </div>
        
                    </div>
                    
                    <!-- Tournaments Grid - Full Width -->                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @forelse($tournaments as $tournament)
                        <div class="bg-gray-800 rounded-lg overflow-hidden hover:transform hover:scale-105 transition duration-300">
                            <!-- Tournament Banner (Full Width) -->
                            @if($tournament->banner)
                                <div class="w-full h-72 overflow-hidden">
                                    <img src="{{ asset('images/tournament_banners/' . basename($tournament->banner)) }}"
                                        alt="{{ $tournament->name }} Banner"
                                        class="w-full h-full object-cover">
                                </div>
                            @endif

                            <!-- Tournament Details -->
                            <div class="p-6">
                                <h3 class="text-2xl font-bold text-white mb-2" title="{{ $tournament->name }}">
                                    {{ \Illuminate\Support\Str::limit($tournament->name, 30) }}
                                </h3>
                                
                                <!-- Date and Time Row -->
                                <div class="flex items-center gap-3 mb-4">
                                @php
                                // Define o local do Carbon para Português do Brasil
                                \Carbon\Carbon::setLocale('pt_BR');

                                // Pega a hora atual no seu fuso horário para uma comparação precisa
                                $nowCarbon = \Carbon\Carbon::now('America/Sao_Paulo');

                                // --- ESTA É A LINHA CORRIGIDA ---
                                // Nós juntamos a data e a hora do torneio para criar um objeto Carbon completo e preciso.
                                $tournamentDateCarbon = \Carbon\Carbon::parse($tournament->tournament_date . ' ' . $tournament->time, 'America/Sao_Paulo');

                                // O resto da sua lógica original, que agora funcionará corretamente
                                $isFutureEvent = $tournamentDateCarbon->isAfter($nowCarbon); // Usar isAfter() é mais claro que isFuture() para evitar bugs de milissegundos
                                
                                // Usamos o valor absoluto da diferença, pois diffInSeconds pode ser negativo
                                $totalSecondsDifference = abs($tournamentDateCarbon->diffInSeconds($nowCarbon));

                                $formattedTimeDifference = ''; // Variável para armazenar o resultado formatado

                                if (!$isFutureEvent && $totalSecondsDifference < 60) {
                                    $formattedTimeDifference = 'agora';
                                } else {
                                    $interval = \Carbon\CarbonInterval::seconds($totalSecondsDifference)->cascade();

                                    $parts = [];
                                    if ($interval->d > 0) {
                                        $parts[] = $interval->d . ' ' . ($interval->d === 1 ? 'dia' : 'dias');
                                    }
                                    if ($interval->h > 0) {
                                        $parts[] = $interval->h . ' ' . ($interval->h === 1 ? 'hora' : 'horas');
                                    }

                                    if (empty($parts)) {
                                        if ($interval->i > 0) {
                                            $parts[] = $interval->i . ' ' . ($interval->i === 1 ? 'minuto' : 'minutos');
                                        } elseif ($interval->s > 0 && $totalSecondsDifference < 60) {
                                            $parts[] = $interval->s . ' ' . ($interval->s === 1 ? 'segundo' : 'segundos');
                                        }
                                    }
                                    
                                    if (!empty($parts)) {
                                        $durationString = implode(' e ', $parts);
                                        if ($isFutureEvent) {
                                            $formattedTimeDifference = 'em ' . $durationString;
                                        } else {
                                            $formattedTimeDifference = $durationString . ' atrás';
                                        }
                                    } elseif ($totalSecondsDifference > 0) {
                                        $formattedTimeDifference = $isFutureEvent ? 'em menos de um minuto' : 'há menos de um minuto';
                                    } else {
                                        $formattedTimeDifference = 'agora';
                                    }
                                }

                                // A sua lógica para $tagText e $tagClass já deve funcionar melhor com a data/hora correta
                                $tagText = '';
                                $tagClass = '';
                                
                                if ($isFutureEvent) {
                                    // ... sua lógica para "EM X DIAS", "EM X HORAS", etc. ...
                                    // Essa parte já deve funcionar melhor agora. Por exemplo:
                                    $tagText = "EM " . $tournamentDateCarbon->diffForHumans(null, true, false, 2); // Exibe "em 2 dias", "em 5 horas"
                                    $tagClass = 'bg-indigo-600';
                                } else {
                                    $hoursPassedSinceStart = $nowCarbon->diffInHours($tournamentDateCarbon);
                                    if ($hoursPassedSinceStart <= 3) { // Janela de "AO VIVO"
                                        $tagText = "AO VIVO";
                                        $tagClass = 'bg-green-600';
                                    } else {
                                        $tagText = "FINALIZADO";
                                        $tagClass = 'bg-red-600';
                                    }
                                }
                            @endphp

                                <div class="flex items-center text-gray-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    {{ $tournamentDateCarbon->translatedFormat('D, d \d\e M') }}
                                </div>
                                                                
                                <div class="flex items-center bg-sky-600 text-white text-xs font-medium px-3 py-1 rounded-full ml-auto">                                   
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        {{ $formattedTimeDifference }}
                                    </div>
                            </div>
                                
                                <!-- Location/Country -->
                                <div class="text-gray-400 mb-4">
                                    <p> Horário: {{ substr($tournament->time, 0, 5 )}}</p>
                                </div>
                                
                                <!-- Creator -->
                                <div class="flex items-center mb-4">
                                    <div class="flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                        <span class="text-white">{{ $tournament->creator->name ?? 'Forja do E-sport' }}</span>
                                    </div>
                                </div>
                                
                                <a href="/tournaments/{{ $tournament->id }}" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 block text-center transition">
                                    Ver Detalhes
                                </a>
                            </div>
                        </div>
                        @empty
                            <div class="col-span-full text-center py-12">
                                <p class="text-gray-400 text-lg mb-6">Nenhum torneio encontrado no momento.</p>
                                @auth
                                    @if(auth()->user()->isAdmin())
                                        <button onclick="toggleCreateForm()" 
                                                class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-lg transition-colors">
                                            Criar Primeiro Torneio
                                        </button>
                                    @else
                                        <p class="text-gray-400">Verifique novamente mais tarde!</p>
                                    @endif
                                @else
                                    <a href="{{ route('login') }}" 
                                    class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-lg transition-colors">
                                        Faça login para ver torneios
                                    </a>
                                @endauth
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Admin Panel - Below Tournaments -->
                @auth
                @if(auth()->user()->isAdmin())
                <div class="mt-12 w-full">
                    <div class="bg-gradient-to-br from-gray-800 via-gray-900 to-gray-800 p-8 rounded-xl shadow-2xl border border-gray-700">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-10 h-10 bg-indigo-600 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <h3 class="text-2xl font-bold text-white">Painel do Administrador</h3>
                        </div>
                        
                        <button onclick="toggleCreateForm()" class="group relative bg-gradient-to-r from-indigo-600 to-purple-600 text-white w-full py-4 rounded-xl mb-6 hover:from-indigo-700 hover:to-purple-700 transition-all duration-300 transform hover:scale-[1.02] shadow-lg hover:shadow-xl">
                            <div class="flex items-center justify-center gap-2">
                                <svg class="w-5 h-5 group-hover:rotate-180 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                <span class="font-semibold">Criar Novo Torneio</span>
                            </div>
                        </button>

                        <!-- Create Tournament Form (Initially Hidden) -->
                        <div id="createForm" class="hidden">
                            <form action="{{ route('tournaments.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="space-y-6">
                                    <!-- Tournament Name -->
                                    <div class="form-group">
                                        <label class="block text-gray-300 mb-2 font-medium">
                                            <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                            </svg>
                                            Nome do Torneio
                                        </label>
                                        <input type="text" name="name" placeholder="Digite o nome do torneio..." 
                                            class="w-full bg-gray-700 text-white rounded-lg p-4 border border-gray-600 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-all duration-200 placeholder-gray-400" required>
                                    </div>
                                    
                                    <!-- Game -->
                                    <div class="form-group">
                                        <label class="block text-gray-300 mb-2 font-medium">
                                            <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h1m4 0h1m-6 4h8m-5-8a3 3 0 114 4.472"></path>
                                            </svg>
                                            Jogo
                                        </label>
                                        <div class="relative">
                                            <select name="game" class="w-full bg-gray-700 text-white rounded-lg p-4 border border-gray-600 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-all duration-200 appearance-none cursor-pointer" required
                                                    onchange="document.getElementById('game-icon').src = this.selectedOptions[0].dataset.icon">
                                                <option value="" disabled selected>Selecione um jogo</option>
                                                <option value="CS2">Counter-Strike 2</option>
                                                <option value="VALORANT">VALORANT</option>
                                                <option value="LOL">League of Legends</option>
                                            </select>
                                            <svg class="absolute right-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    
                                    <!-- Participant Option (Hidden) -->
                                    <input type="hidden" name="participant_option" id="participantOption" value="preset">
                                    
                                    <!-- Max Participants -->
                                    <div class="form-group">
                                        <label class="block text-gray-300 mb-2 font-medium">
                                            <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                            </svg>
                                            Número máximo de equipes participantes
                                        </label>
                                        <div class="relative">
                                            <select name="max_participants" 
                                                    class="w-full bg-gray-700 text-white rounded-lg p-4 border border-gray-600 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-all duration-200 appearance-none cursor-pointer"
                                                    required>
                                                <option value="" disabled selected>Selecione uma opção</option>
                                                <option value="8">8 equipes</option>
                                                <option value="16">16 equipes</option>
                                                <option value="32">32 equipes</option>
                                                <option value="64">64 equipes</option>
                                                <option value="128">128 equipes</option>
                                            </select>
                                            <svg class="absolute right-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                            </svg>
                                        </div>
                                    </div>

                                    <!-- Date and Time Section -->
                                    <div class="bg-gray-800/50 p-6 rounded-lg border border-gray-600">
                                        <h4 class="text-lg font-semibold text-white mb-4 flex items-center gap-2">
                                            <svg class="w-5 h-5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                            Programação do Torneio
                                        </h4>
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">                                       
                                            <!-- Tournament Date -->
                                            <div>
                                                <label class="block text-gray-300 mb-2 font-medium">Data do Torneio</label>
                                                <input type="date" name="tournament_date" 
                                                    class="w-full bg-gray-700 text-white rounded-lg p-4 border border-gray-600 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-all duration-200" 
                                                    min="{{ \Carbon\Carbon::now('America/Sao_Paulo') }}"
                                                    required>
                                            </div>

                                            <!-- Tournament Time -->
                                            <div>
                                                <label class="block text-gray-300 mb-2 font-medium">Hora do Torneio</label>
                                                <input type="time" name="time"
                                                    class="w-full bg-gray-700 text-white rounded-lg p-4 border border-gray-600 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-all duration-200"
                                                    required>
                                                <p class="text-gray-400 text-sm mt-2 flex items-center gap-1">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                    Horário de início do torneio
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Text Areas Section -->
                                    <div class="space-y-4">
                                        <!-- Description -->
                                        <div class="form-group">
                                            <label class="block text-gray-300 mb-2 font-medium">
                                                <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                </svg>
                                                Descrição
                                            </label>
                                            <textarea name="description" placeholder="Descreva o torneio, formato, etc..." 
                                                class="w-full bg-gray-700 text-white rounded-lg p-4 border border-gray-600 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-all duration-200 placeholder-gray-400 resize-vertical" rows="4"></textarea>
                                        </div>

                                        <!-- Rules -->
                                        <div class="form-group">
                                            <label class="block text-gray-300 mb-2 font-medium">
                                                <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                                </svg>
                                                Regras do Torneio
                                            </label>
                                            <textarea name="rules" placeholder="Defina as regras e condições do torneio..." 
                                                class="w-full bg-gray-700 text-white rounded-lg p-4 border border-gray-600 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-all duration-200 placeholder-gray-400 resize-vertical" rows="4"></textarea>
                                        </div>

                                        <!-- Prizes -->
                                        <div class="form-group">
                                            <label class="block text-gray-300 mb-2 font-medium">
                                                <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                                                </svg>
                                                Premiações
                                            </label>
                                            <textarea name="prizes" placeholder="Descreva as premiações e recompensas..." 
                                                class="w-full bg-gray-700 text-white rounded-lg p-4 border border-gray-600 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-all duration-200 placeholder-gray-400 resize-vertical" rows="3"></textarea>
                                        </div>
                                    </div>
                                    
                                    <!-- Banner Upload Section -->
                                    <div class="bg-gray-800/50 p-6 rounded-lg border border-gray-600">
                                        <label for="bannerInput" class="block text-gray-300 mb-3 font-medium">
                                            <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                            Banner do Torneio
                                        </label>
                                        <div class="relative group">
                                            <input type="file" id="bannerInput" name="banner" 
                                                class="w-full text-white p-4 border-2 border-dashed border-gray-600 rounded-lg bg-gray-700 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-600 file:text-white hover:file:bg-indigo-700 file:cursor-pointer hover:border-indigo-500 transition-all duration-200" 
                                                accept="image/*" required>
                                            <p class="text-gray-400 text-sm mt-2">Formatos aceitos: JPG, PNG, GIF (máx. 5MB)</p>
                                        </div>

                                        <div class="w-full mt-4" id="previewContainer" style="display: none;">
                                            <div class="relative w-full h-72 overflow-hidden border-2 border-gray-600 rounded-lg bg-gray-800">
                                                <img id="bannerPreview" class="w-full h-full object-cover rounded-lg">
                                                <div class="absolute inset-0 bg-black bg-opacity-0 hover:bg-opacity-20 transition-all duration-200 flex items-center justify-center opacity-0 hover:opacity-100">
                                                    <p class="text-white font-medium">Preview do Banner</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Submit Button -->
                                    <div class="pt-4">
                                        <button type="submit" class="group relative bg-gradient-to-r from-green-600 to-emerald-600 text-white w-full py-4 rounded-xl hover:from-green-700 hover:to-emerald-700 transition-all duration-300 transform hover:scale-[1.02] shadow-lg hover:shadow-xl font-semibold text-lg">
                                            <div class="flex items-center justify-center gap-2">
                                                <svg class="w-5 h-5 group-hover:rotate-12 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                                </svg>
                                                Publicar Torneio
                                            </div>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                @endif
                @endauth
            </div>
        </section>

        <script>
            function toggleCreateForm() {
                const form = document.getElementById('createForm');
                form.classList.toggle('hidden');
            }

            document.addEventListener('DOMContentLoaded', function() {
                const tournamentDateInput = document.querySelector('input[name="tournament_date"]');
                
                const currentYear = new Date().getFullYear();
                const nextYear = currentYear + 1;
                
                // Function to validate a complete date
                function isValidDate(dateString) {
                    const regEx = /^\d{4}-\d{2}-\d{2}$/;
                    if (!dateString.match(regEx)) return false;
                    const d = new Date(dateString);
                    return !isNaN(d.getTime());
                }

                // Set initial min/max dates for all date inputs
                const setupDateInput = (input) => {
                    const today = new Date();
                    const nextYear = today.getFullYear() + 1;

                    //YYYY-MM-DD
                    const currentDate = today.toISOString().split('T')[0];

                    input.min = currentDate;
                    input.max = `${nextYear}-12-31`;
                    
                    input.addEventListener('input', function() {
                        // Only validate when we have a complete date (10 chars: YYYY-MM-DD)
                        if (this.value.length === 10) {
                            if (!isValidDate(this.value)) {
                                this.setCustomValidity('Data inválida');
                                return;
                            }
                            
                            const selectedDate = new Date(this.value);
                            const selectedYear = selectedDate.getFullYear();
                            
                            if (selectedYear < currentYear || selectedYear > nextYear) {
                                this.setCustomValidity(`Ano deve ser entre ${currentYear} e ${nextYear}`);
                            } else {
                                this.setCustomValidity('');
                            }
                        } else {
                            this.setCustomValidity('');
                        }
                    });
                    
                    input.addEventListener('blur', function() {
                        if (this.value && !isValidDate(this.value)) {
                            this.value = '';
                            alert('Por favor, insira uma data válida no formato DD/MM/AAAA');
                        }
                    });
                };
                
                // Apply to all date inputs
                setupDateInput(tournamentDateInput);
                

                // Form submission validation
                document.querySelector('form').addEventListener('submit', function(e) {
                    const dateInputs = [tournamentDateInput];
                    let isValid = true;
                    
                    dateInputs.forEach(input => {
                        if (input.value && !isValidDate(input.value)) {
                            alert('Por favor, insira datas válidas no formato DD/MM/AAAA');
                            isValid = false;
                        }
                    });
                    
                    if (!isValid) {
                        e.preventDefault();
                    }
                });
            });
            
            document.addEventListener('DOMContentLoaded', function () {
    const imageInput = document.getElementById('bannerInput');
    const previewContainer = document.getElementById('previewContainer');
    const imagePreview = document.getElementById('bannerPreview');

    if (imageInput && previewContainer && imagePreview) {
        imageInput.addEventListener('change', function(event) {
            const file = event.target.files[0];

            if (file) {
                const localImageUrl = URL.createObjectURL(file);
                
                imagePreview.src = localImageUrl;

                previewContainer.style.display = 'block';
            } else {
                previewContainer.style.display = 'none';
            }
        });
    }
});
</script>
    
@endsection