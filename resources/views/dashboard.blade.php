@extends('layouts.app')

@section('title', 'Meus Torneios')

@section('content')
    <!-- ===========Banner Section start Here========== -->
    <section class="pageheader-section" style="background-image: url(images/pageheader/bg.jpg);">
        <section class="bg-gray-900 min-h-screen">
            <div class="container py-12 px-4 mx-auto">
                <!-- Main Content Area - Full Width -->
                <div class="w-full">
                    <!-- Tournaments Header -->
                    <div class="mb-8">
                        <h1 class="text-4xl font-bold text-white mb-6">Encontre Torneiros</h1>
                        
                        <!-- Filter Options -->
                        <div class="flex flex-wrap gap-3">
                            <button class="bg-gray-800 hover:bg-gray-700 text-white px-6 py-3 rounded-md flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                Date
                            </button>     
                            
                            <div class="relative group">
                                <button class="bg-gray-800 hover:bg-gray-700 text-white px-6 py-3 rounded-md flex items-center">
                                    Game
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>
                                
                                <!-- Dropdown menu -->
                                <div class="absolute z-10 hidden group-hover:block mt-1 w-48 bg-gray-800 rounded-md shadow-lg">
                                    <div class="py-1">
                                        <!-- CS2 Option -->
                                        <a href="#" class="flex items-center px-4 py-2 text-sm text-gray-300 hover:bg-gray-700">
                                            <img src="https://upload.wikimedia.org/wikipedia/commons/6/6e/CS2_logo.svg" alt="CS2" class="w-5 h-5 mr-3">
                                            Counter-Strike 2
                                        </a>
                                        
                                        <!-- League of Legends Option -->
                                        <a href="#" class="flex items-center px-4 py-2 text-sm text-gray-300 hover:bg-gray-700">
                                            <img src="https://upload.wikimedia.org/wikipedia/commons/d/d8/League_of_Legends_2019_vector.svg" alt="LoL" class="w-5 h-5 mr-3">
                                            League of Legends
                                        </a>
                                        
                                        <!-- VALORANT Option -->
                                        <a href="#" class="flex items-center px-4 py-2 text-sm text-gray-300 hover:bg-gray-700">
                                            <img src="https://upload.wikimedia.org/wikipedia/commons/f/fc/Valorant_logo_-_pink_color_version.svg" alt="VALORANT" class="w-5 h-5 mr-3">
                                            VALORANT
                                        </a>
                                        
                                        <!-- All Games Option -->
                                        <a href="#" class="flex items-center px-4 py-2 text-sm text-gray-300 hover:bg-gray-700 border-t border-gray-700">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                            </svg>
                                            All Games
                                        </a>
                                    </div>
                                </div>
                            </div>
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
                                    Log::info('Tournament Date: ' . $tournament->tournament_date);
                                    $tournamentDateCarbon = \Carbon\Carbon::parse($tournament->tournament_date);
                                    Log::info('Tournament Date Carbon: ' . $tournamentDateCarbon->toDateTimeString());
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
                                            <option value="16">16 equipes</option>
                                            <option value="32">32 equipes</option>
                                            <option value="64">64 equipes</option>
                                            <option value="128">128 equipes</option>
                                        </select>
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                        <!-- Start Date -->
                                        <div>
                                            <label class="block text-gray-300 mb-1">Início das Inscrições</label>
                                            <input type="date" name="start_date" 
                                                class="w-full bg-gray-700 text-white rounded-lg p-2" 
                                                min="{{ now()->format('Y-m-d') }}"
                                                required>
                                            <p class="text-gray-400 text-xs mt-1">A partir de hoje</p>
                                        </div>
                                        
                                        <!-- End Date -->
                                        <div>
                                            <label class="block text-gray-300 mb-1">Fim das Inscrições</label>
                                            <input type="date" name="end_date" 
                                                class="w-full bg-gray-700 text-white rounded-lg p-2" 
                                                min="{{ now()->addDay()->format('Y-m-d') }}"
                                                required>
                                            <p class="text-gray-400 text-xs mt-1">Pelo menos 1 dia após o início das inscrições</p>
                                        </div>
                                        
                                        <!-- Tournament Date -->
                                        <div>
                                            <label class="block text-gray-300 mb-1">Data do Torneio</label>
                                            <input type="date" name="tournament_date" 
                                                class="w-full bg-gray-700 text-white rounded-lg p-2" 
                                                min="{{ now()->addDays(2)->format('Y-m-d') }}"
                                                required>
                                            <p class="text-gray-400 text-xs mt-1">Pelo menos 1 dia após o fim das inscrições</p>
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

                                    <!-- Banner Upload -->
                                    <input type="file" name="banner" id="bannerInput" class="w-full text-white" accept="image/*" required>

                                    <!-- Image Preview and Crop Area -->
                                    <div class="w-full mt-4">
                                        <label class="block text-gray-300 mb-2">Prévia do banner</label>
                                        <div class="relative w-full h-56 overflow-hidden border border-gray-600 rounded">
                                            <img id="imagePreview" class="w-full h-full object-cover" style="display: none;">
                                        </div>
                                    </div>
                                    <input type="hidden" name="banner" id="croppedBanner">

                                    <!-- Hidden field to store cropped image -->
                                    <input type="hidden" name="banner" id="croppedBannerInput">

                                    
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
        
            function toggleCustomInput(select) {
                const container = document.getElementById('customParticipantsContainer');
                const customInput = document.getElementById('customParticipantsInput');
                const participantOption = document.getElementById('participantOption');
                
                if (select.value === 'custom') {
                    container.classList.remove('hidden');
                    customInput.value = '';
                    participantOption.value = 'custom';
                    select.classList.add('hidden');
                    
                    if (!document.getElementById('backToPresets')) {
                        const backButton = document.createElement('button');
                        backButton.id = 'backToPresets';
                        backButton.type = 'button';
                        backButton.textContent = '← Voltar para opções pré-definidas';
                        backButton.className = 'text-blue-400 text-sm mt-2 hover:underline';
                        backButton.onclick = function() {
                            container.classList.add('hidden');
                            select.value = '';
                            select.classList.remove('hidden');
                            if (document.getElementById('backToPresets')) {
                                backButton.remove();
                            }
                        };
                        container.parentNode.insertBefore(backButton, container.nextSibling);
                    }
                } else {
                    container.classList.add('hidden');
                    participantOption.value = 'preset';
                    const backButton = document.getElementById('backToPresets');
                    if (backButton) {
                        backButton.remove();
                    }
                }
            }
        
            document.addEventListener('DOMContentLoaded', function() {
                const startDateInput = document.querySelector('input[name="start_date"]');
                const endDateInput = document.querySelector('input[name="end_date"]');
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
                setupDateInput(startDateInput);
                setupDateInput(endDateInput);
                setupDateInput(tournamentDateInput);

                // Date relationship validation
                startDateInput.addEventListener('change', function() {
                    if (this.value && isValidDate(this.value)) {
                        const startDate = new Date(this.value);
                        const minEndDate = new Date(startDate);
                        minEndDate.setDate(minEndDate.getDate() + 1);
                        
                        endDateInput.min = minEndDate.toISOString().split('T')[0];
                        
                        if (endDateInput.value && new Date(endDateInput.value) < minEndDate) {
                            endDateInput.value = '';
                        }
                    }
                });

                endDateInput.addEventListener('change', function() {
                    if (this.value && isValidDate(this.value)) {
                        const endDate = new Date(this.value);
                        const minTournamentDate = new Date(endDate);
                        minTournamentDate.setDate(minTournamentDate.getDate() + 1);
                        
                        tournamentDateInput.min = minTournamentDate.toISOString().split('T')[0];
                        
                        if (tournamentDateInput.value && new Date(tournamentDateInput.value) < minTournamentDate) {
                            tournamentDateInput.value = '';
                        }
                    }
                });

                // Form submission validation
                document.querySelector('form').addEventListener('submit', function(e) {
                    const dateInputs = [startDateInput, endDateInput, tournamentDateInput];
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

            let cropper;
            const input = document.querySelector('input[name="banner"]');
            const preview = document.getElementById('imagePreview');
            const croppedBanner = document.getElementById('croppedBanner');

            input.addEventListener('change', (e) => {
                const file = e.target.files[0];
                if (!file) return;

                const reader = new FileReader();
                reader.onload = () => {
                    preview.src = reader.result;
                    preview.style.display = 'block';

                    if (cropper) cropper.destroy();

                    cropper = new Cropper(preview, {
                        aspectRatio: 16 / 5, // same as w-full h-56 (roughly 320x112)
                        viewMode: 1,
                        autoCropArea: 1,
                        cropend() {
                            const canvas = cropper.getCroppedCanvas({
                                width: 1280, // or desired banner size
                                height: 448
                            });
                            croppedBanner.value = canvas.toDataURL('image/jpeg');
                        }
                    });
                };
                reader.readAsDataURL(file);
            });

            // Intercept form submission to crop the image first
            document.querySelector('form').addEventListener('submit', function(e) {
                if (cropper) {
                    e.preventDefault(); // prevent form until image is cropped

                    cropper.getCroppedCanvas().toBlob(function(blob) {
                        const reader = new FileReader();
                        reader.onloadend = function() {
                            croppedBannerInput.value = reader.result;
                            e.target.submit(); // now submit form with cropped image
                        };
                        reader.readAsDataURL(blob);
                    });
                }
            });
        </script>
    </section>
@endsection