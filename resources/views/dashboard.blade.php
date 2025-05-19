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
                            
                            <div class="relative">
                                <button class="bg-gray-800 hover:bg-gray-700 text-white px-6 py-3 rounded-md flex items-center">
                                    Any Bracket
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>
                            </div>
                            
                            <div class="relative">
                                <button class="bg-gray-800 hover:bg-gray-700 text-white px-6 py-3 rounded-md flex items-center">
                                    Any Format
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>
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
                                    <div class="flex items-center text-gray-300">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        {{ \Carbon\Carbon::parse($tournament->tournament_date)->format('D M d') }}
                                    </div>
                                    
                                    <div class="flex items-center text-gray-300">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        {{ \Carbon\Carbon::parse($tournament->tournament_date)->format('g:i A') }}
                                    </div>
                                    
                                    <!-- Time Countdown Tag -->
                                    @php
                                        $tournamentDate = \Carbon\Carbon::parse($tournament->tournament_date);
                                        $now = \Carbon\Carbon::now();
                                        $diffHours = $tournamentDate->diffInHours($now);
                                        $diffDays = $tournamentDate->diffInDays($now);
                                    @endphp
                                    
                                    @if($diffDays > 0)
                                        <div class="bg-indigo-600 text-white text-xs px-3 py-1 rounded-full">
                                            IN {{ $diffDays }} DAY{{ $diffDays > 1 ? 'S' : '' }}
                                        </div>
                                    @elseif($diffHours > 0)
                                        <div class="bg-indigo-600 text-white text-xs px-3 py-1 rounded-full">
                                            IN {{ $diffHours }} HOUR{{ $diffHours > 1 ? 'S' : '' }}
                                        </div>
                                    @else
                                        <div class="bg-green-600 text-white text-xs px-3 py-1 rounded-full">
                                            LIVE NOW
                                        </div>
                                    @endif
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

                                    <!-- Prizes -->
                                    <textarea name="prizes" placeholder="Premiações" 
                                        class="w-full bg-gray-700 text-white rounded-lg p-2"></textarea>

                                    <!-- Banner Upload -->
                                    <input type="file" name="banner" id="bannerInput" class="w-full text-white" accept="image/*" required>

                                    <!-- Preview Container -->
                                    <div class="mt-4">
                                        <img id="bannerPreview" class="max-h-64 rounded-lg object-contain border border-gray-500" style="display: none;" />
                                    </div>

                                    <!-- Hidden field to store cropped image -->
                                    <input type="hidden" name="cropped_banner" id="croppedBannerInput">

                                    
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
            const bannerInput = document.getElementById('bannerInput');
            const bannerPreview = document.getElementById('bannerPreview');
            const croppedBannerInput = document.getElementById('croppedBannerInput');

            bannerInput.addEventListener('change', (event) => {
                const file = event.target.files[0];
                if (file && file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        bannerPreview.src = e.target.result;
                        bannerPreview.style.display = 'block';

                        if (cropper) {
                            cropper.destroy();
                        }

                        cropper = new Cropper(bannerPreview, {
                            aspectRatio: 16 / 9, // Or whatever aspect ratio your banner uses
                            viewMode: 1,
                            autoCropArea: 1,
                        });
                    };
                    reader.readAsDataURL(file);
                }
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