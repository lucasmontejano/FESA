@extends('layouts.app')

@section('title', 'Meus Torneios')

@section('content')
    <!-- ===========Banner Section start Here========== -->
    <section class="pageheader-section" style="background-image: url(images/pageheader/bg.jpg);">
        <div class="container py-8">
            <!-- Main Content Area - Full Width -->
            <div class="w-full">
                <!-- Tournaments Header -->
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-3xl font-bold text-white">Torneios Ativos</h2>
                    <div class="relative">
                        <select class="bg-gray-800 text-white px-4 py-2 rounded-lg">
                            <option>Filtrar por Jogo</option>
                            <option>CS:GO</option>
                            <option>League of Legends</option>
                            <option>Valorant</option>
                        </select>
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
                               
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @forelse($tournaments as $tournament)
                    <div class="bg-gray-800 rounded-lg p-6 hover:bg-gray-700 transition">
                        <!-- Tournament Image -->
                        @if($tournament->banner)
                            <div class="w-full h-48 overflow-hidden rounded-t-lg">
                                <img src="{{ asset('images/tournament_banners/' . basename($tournament->banner)) }}" 
                                    alt="{{ $tournament->name }} Banner"
                                    class="w-full h-full object-cover">
                            </div>
                        @endif

                        <div class="flex items-center mb-4">
                            <img src="{{ $tournament->game_logo }}" alt="Game Logo" class="w-12 h-12 mr-4">
                            <div>
                                <h3 class="text-xl font-bold text-white">{{ $tournament->name }}</h3>
                                <p class="text-gray-400">{{ $tournament->game }}</p>
                            </div>
                        </div>
                        <div class="flex justify-between text-sm text-gray-400 mb-4">
                            <div>
                                <i class="icofont-calendar"></i>
                                {{ $tournament->start_date }} - {{ $tournament->end_date }}
                            </div>
                            <div>
                                <i class="icofont-users"></i>
                                {{ $tournament->participants_count }} participantes
                            </div>
                        </div>
                        <a href="/tournaments/{{ $tournament->id }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 block text-center">
                            Ver Detalhes
                        </a>
                    </div>
                    @empty
                        <div class="col-span-full text-center py-8">
                            <p class="text-gray-400 text-lg mb-4">Nenhum torneio encontrado no momento.</p>
                            @auth
                                @if(auth()->user()->isAdmin())
                                    <button onclick="toggleCreateForm()" 
                                            class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg transition-colors">
                                        Criar Primeiro Torneio
                                    </button>
                                @else
                                    <p class="text-gray-400">Verifique novamente mais tarde!</p>
                                @endif
                            @else
                                <a href="{{ route('login') }}" 
                                class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition-colors">
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
            <div class="mt-8 w-full"> <!-- Added margin-top and full width -->
                <div class="bg-gray-800 p-6 rounded-lg">
                    <h3 class="text-xl font-bold text-white mb-4">Painel do Administrador</h3>
                    <button onclick="toggleCreateForm()" class="bg-green-600 text-white w-full py-2 rounded-lg mb-4 hover:bg-green-700">
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
                                <input type="text" name="game" placeholder="Jogo" 
                                    class="w-full bg-gray-700 text-white rounded-lg p-2" required>
                                
                                <!-- Participant Option (Hidden) -->
                                <input type="hidden" name="participant_option" id="participantOption" value="preset">
                                
                                <!-- Max Participants -->
                                <div class="mb-4">
                                    <label class="block text-gray-300 mb-2">Número máximo de participantes</label>
                                    <select name="max_participants" 
                                            class="w-full bg-gray-700 text-white rounded-lg p-2"
                                            id="participantSelect"
                                            onchange="toggleCustomInput(this)">
                                        <option value="" disabled selected>Selecione uma opção</option>
                                        <option value="8">8 participantes</option>
                                        <option value="16">16 participantes</option>
                                        <option value="32">32 participantes</option>
                                        <option value="64">64 participantes</option>
                                        <option value="128">128 participantes</option>
                                        <option value="custom">Personalizado</option>
                                    </select>
                                    
                                    <!-- Custom Input (hidden by default) -->
                                    <div id="customParticipantsContainer" class="hidden mt-2">
                                        <input type="number" name="max_participants" 
                                            min="8" max="256"
                                            class="w-full bg-gray-700 text-white rounded-lg p-2"
                                            id="customParticipantsInput"
                                            placeholder="Digite o número de participantes (8-256)">
                                        <p class="text-yellow-400 text-sm mt-1">
                                            ⚠️ Valores diferentes podem afetar o pareamento e a experiência do torneio.
                                        </p>
                                    </div>
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
                                        <p class="text-gray-400 text-xs mt-1">Pelo menos 1 dia após o início</p>
                                    </div>
                                    
                                    <!-- Tournament Date -->
                                    <div>
                                        <label class="block text-gray-300 mb-1">Data do Torneio</label>
                                        <input type="date" name="tournament_date" 
                                               class="w-full bg-gray-700 text-white rounded-lg p-2" 
                                               min="{{ now()->addDays(2)->format('Y-m-d') }}"
                                               required>
                                        <p class="text-gray-400 text-xs mt-1">Pelo menos 1 dia após o fim</p>
                                    </div>
                                </div>

                                <!-- Description -->
                                <textarea name="description" placeholder="Descrição" 
                                        class="w-full bg-gray-700 text-white rounded-lg p-2"></textarea>
                                
                                <!-- Banner -->
                                <input type="file" name="banner" class="w-full text-white" required>
                                
                                <!-- Submit Button -->
                                <button type="submit" class="bg-blue-600 text-white w-full py-2 rounded-lg hover:bg-blue-700">
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
                input.min = `${currentYear}-01-01`;
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
    </script>
@endsection