@extends('layouts.app')

@section('title', 'Meus Torneios')

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
                    
                    {{-- ### INÍCIO DA MUDANÇA ### --}}
                    <a href="{{-- Se o filtro já estiver ativo, o link limpa o filtro. Senão, ele aplica o filtro. --}}
                              {{ $isActive 
                                    ? route('dashboard', ['status' => request('status', 'upcoming')]) 
                                    : route('dashboard', ['status' => request('status', 'upcoming'), 'game' => $game]) 
                              }}" 
                       class="flex items-center px-4 py-2 text-sm rounded-md transition-colors duration-200
                              {{ $isActive ? 'bg-blue-600/30 text-white ring-2 ring-blue-500' : 'text-gray-300 hover:bg-gray-700' }}">
                    {{-- ### FIM DA MUDANÇA ### --}}
                        
                        {{-- Ícones para cada jogo --}}
                        @if(strcasecmp($game, 'CS2') === 0)
                            <img src="https://upload.wikimedia.org/wikipedia/commons/6/6e/CS2_logo.svg" alt="CS2" class="w-5 h-5 mr-3">
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

                    <!-- Error/Success Messages -->
                    @if($errors->any())
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                            {{ session('success') }}
                        </div>
                    @endif
                    
                    <!-- Tournaments Grid - Full Width -->                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @forelse($tournaments as $tournament)
                        <div class="bg-gray-800 rounded-lg overflow-hidden hover:transform hover:scale-105 transition duration-300">
                            <!-- Tournament Banner (Full Width) -->
                            @if($tournament->banner)
                                <div class="w-full h-56 overflow-hidden">
                                    <img src="{{ asset('images/tournament_banners/' . basename($tournament->banner)) }}"
                                        alt="{{ $tournament->name }} Banner"
                                        class="w-full h-full object-cover">
                                </div>
                            @endif

                            <!-- Tournament Details -->
                            <div class="p-6">
                                <h3 class="text-2xl font-bold text-white mb-2">{{ $tournament->name }}</h3>
                                
                                <!-- Date and Time Row -->
                                <div class="flex items-center gap-3 mb-4">
                                @php
                                    // Define o local do Carbon para Português do Brasil
                                    \Carbon\Carbon::setLocale('pt_BR');
                                    $tournamentDateCarbon = \Carbon\Carbon::parse($tournament->tournament_date);
                                    $nowCarbon = \Carbon\Carbon::now();
                                    $totalSecondsDifference = $tournamentDateCarbon->diffInSeconds($nowCarbon);

                                    $isFutureEvent = $tournamentDateCarbon->isFuture();

                                    $formattedTimeDifference = ''; // Variável para armazenar o resultado formatado

                                    if ($totalSecondsDifference == 0) {
                                        $formattedTimeDifference = 'agora';
                                    } else {
                                        $interval = \Carbon\CarbonInterval::seconds($totalSecondsDifference)->cascade();

                                        $parts = [];
                                        if ($interval->d > 0) { // d é a propriedade para dias no DateInterval/CarbonInterval
                                            $parts[] = $interval->d . ' ' . ($interval->d === 1 ? 'dia' : 'dias');
                                        }
                                        if ($interval->h > 0) { // h é a propriedade para horas
                                            $parts[] = $interval->h . ' ' . ($interval->h === 1 ? 'hora' : 'horas');
                                        }

                                        if (empty($parts)) {
                                            if ($interval->i > 0) { // i é a propriedade para minutos
                                                $parts[] = $interval->i . ' ' . ($interval->i === 1 ? 'minuto' : 'minutos');
                                            } elseif ($interval->s > 0 && $totalSecondsDifference < 60) { // s é a propriedade para segundos
                                                // Mostrar segundos apenas se a diferença total for menor que um minuto
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
                                        } elseif ($totalSecondsDifference > 0) { // Fallback se parts ainda estiver vazio mas houver diferença
                                            $formattedTimeDifference = 'menos de um minuto';
                                            if ($isFutureEvent) { $formattedTimeDifference = 'em ' . $formattedTimeDifference; }
                                            else { $formattedTimeDifference = $formattedTimeDifference . ' atrás';}
                                        }
                                    }

                                    // Lógica para o texto e classe da tag de contagem regressiva/status
                                    $tagText = '';
                                    $tagClass = '';

                                    if ($nowCarbon->lt($tournamentDateCarbon)) { // Torneio está no futuro
                                        $diffDays = $nowCarbon->diffInDays($tournamentDateCarbon);
                                        $diffHours = $nowCarbon->diffInHours($tournamentDateCarbon); // Total de horas até o torneio
                                        $diffMinutes = $nowCarbon->diffInMinutes($tournamentDateCarbon); // Total de minutos até o torneio

                                        if ($diffDays > 0) {
                                            $tagText = "EM {$diffDays} DIA" . ($diffDays > 1 ? 'S' : '');
                                            $tagClass = 'bg-indigo-600'; // Azul para futuro distante
                                        } elseif ($diffHours > 0) { // Torneio é hoje, horas restantes
                                            $tagText = "EM {$diffHours} HORA" . ($diffHours > 1 ? 'S' : '');
                                            $tagClass = 'bg-indigo-600'; // Azul para futuro próximo (horas)
                                        } elseif ($diffMinutes > 0) { // Torneio é hoje, minutos restantes
                                            $tagText = "EM {$diffMinutes} MINUTO" . ($diffMinutes > 1 ? 'S' : '');
                                            $tagClass = 'bg-yellow-500 text-black'; // Amarelo para "em breve" (minutos)
                                        } else { // Praticamente agora
                                            $tagText = "EM INSTANTES";
                                            $tagClass = 'bg-green-600'; // Verde para "quase lá" ou "começando"
                                        }
                                    } else { // Horário do torneio chegou ou já passou
                                        // Considera uma "janela ao vivo", por exemplo, por 3 horas após o início
                                        $hoursPassedSinceStart = $tournamentDateCarbon->diffInHours($nowCarbon);
                                        if ($hoursPassedSinceStart <= 3) { // Mostrar "AO VIVO" por 3 horas após o início
                                            $tagText = "AO VIVO";
                                            $tagClass = 'bg-green-600';
                                        } else {
                                            $tagText = "FINALIZADO";
                                            $tagClass = 'bg-red-600'; // Vermelho para "finalizado"
                                        }
                                    }
                                @endphp

                                {{-- Data Formatada --}}
                                <div class="flex items-center text-gray-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    {{-- Exemplo: Seg, 26 de Maio --}}
                                    {{ $tournamentDateCarbon->translatedFormat('D, d \d\e M') }}
                                </div>
                                                                
                                {{-- Hora Formatada --}}
                                <div class="flex items-center bg-sky-600 text-white text-xs font-medium px-3 py-1 rounded-full ml-auto">                                   
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            {{-- Ícone ajustado para h-4 w-4 e mr-1.5 para melhor harmonia com text-xs --}}
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        {{ $formattedTimeDifference }}
                                    </div>
                            </div>
                                
                                <!-- Location/Country -->
                                <div class="text-gray-400 mb-4">
                                    {{ $tournament->location ?? 'Brazil' }}
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
                <div class="mt-12 w-full"> <!-- Added margin-top and full width -->
                    <div class="bg-gray-800 p-6 rounded-lg">
                        <h3 class="text-xl font-bold text-white mb-4">Painel do Administrador</h3>
                        <button onclick="toggleCreateForm()" class="bg-indigo-600 text-white w-full py-2 rounded-lg mb-4 hover:bg-indigo-700 transition">
                            Criar Novo Torneio
                        </button>

                        <!-- Create Tournament Form (Initially Hidden) -->
                        <div id="createForm" class="hidden">
                            <form action="{{ route('tournaments.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="space-y-4">
                                    <!-- Tournament Name -->
                                    <input type="text" name="name" placeholder="Nome do Torneio" 
                                        class="w-full bg-gray-700 text-white rounded-lg p-2" required>
                                    
                                    <!-- Game -->
                                    <div class="mb-4">
                                        <label class="block text-gray-300 mb-2">Jogo</label>
                                        <div class="relative">
                                            <select name="game" class="w-full bg-gray-700 text-white rounded-lg p-2 pl-10 appearance-none" required
                                                    onchange="document.getElementById('game-icon').src = this.selectedOptions[0].dataset.icon">
                                                <option value="" disabled selected>Selecione um jogo</option>
                                                <option value="CS2">
                                                    Counter-Strike 2
                                                </option>
                                                <option value="VALORANT">
                                                    VALORANT
                                                </option>
                                                <option value="LOL">
                                                    League of Legends
                                                </option>
                                            </select>
                                            
                                        </div>
                                    </div>
                                    
                                    <!-- Participant Option (Hidden) -->
                                    <input type="hidden" name="participant_option" id="participantOption" value="preset">
                                    
                                    <!-- Max Participants -->
                                    <div class="mb-4">
                                        <label class="block text-gray-300 mb-2">Número máximo de equipes participantes</label>
                                        <select name="max_participants" 
                                                class="w-full bg-gray-700 text-white rounded-lg p-2"
                                                required>
                                            <option value="" disabled selected>Selecione uma opção</option>
                                            <option value="16">8 equipes</option>
                                            <option value="16">16 equipes</option>
                                            <option value="32">32 equipes</option>
                                            <option value="64">64 equipes</option>
                                            <option value="128">128 equipes</option>
                                        </select>
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">                                       
                                        <!-- Tournament Date -->
                                        <div>
                                            <label class="block text-gray-300 mb-1">Data do Torneio</label>
                                            <input type="date" name="tournament_date" 
                                                class="w-full bg-gray-700 text-white rounded-lg p-2" 
                                                min="{{ \Carbon\Carbon::now('America/Sao_Paulo') }}"
                                                required>
                                        </div>

                                        <!-- Tournament Time -->
                                        <div>
                                            <label class="block text-gray-300 mb-1">Hora do Torneio</label>
                                            <input type="time" name="time"
                                                class="w-full bg-gray-700 text-white rounded-lg p-2"
                                                required>
                                            <p class="text-gray-400 text-xs mt-1">Horário de início do torneio</p>
                                        </div>
                                    </div>

                                    <!-- Description -->
                                    <textarea name="description" placeholder="Descrição" 
                                        class="w-full bg-gray-700 text-white rounded-lg p-2"></textarea>

                                    <!-- Rules -->
                                    <textarea name="rules" placeholder="Regras do torneio" 
                                        class="w-full bg-gray-700 text-white rounded-lg p-2"></textarea>

                                    <!-- prizes -->
                                    <textarea name="prizes" placeholder="Premiações" 
                                        class="w-full bg-gray-700 text-white rounded-lg p-2"></textarea>
                                    
                                    <div>
                                        <label for="bannerInput" class="block text-gray-300 mb-1 font-semibold">Banner do Torneio</label>
                                        <input type="file" id="bannerInput" name="banner" 
                                            class="w-full text-white file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" 
                                            accept="image/*" required>
                                    </div>

                                    <div class="w-full mt-4" id="previewContainer" style="display: none;">
                                        <label class="block text-gray-300 mb-2"></label>
                                        
                                        <div class="relative w-full h-72 overflow-hidden border border-gray-600 rounded">
                                            <img id="bannerPreview" class="w-full h-full object-cover" src="">
                                        </div>
                                    </div>

                                    <!-- Submit Button -->
                                    <button type="submit" class="bg-indigo-600 text-white w-full py-2 rounded-lg hover:bg-indigo-700 transition">
                                        Publicar Torneio
                                    </button>
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
                // Cria uma URL temporária para o arquivo de imagem selecionado
                const localImageUrl = URL.createObjectURL(file);
                
                // Define essa URL como a fonte da imagem de prévia
                imagePreview.src = localImageUrl;

                // Mostra o contêiner da prévia
                previewContainer.style.display = 'block';
            } else {
                // Esconde a prévia se o usuário cancelar a seleção de arquivo
                previewContainer.style.display = 'none';
            }
        });
    }
});
</script>
    
@endsection