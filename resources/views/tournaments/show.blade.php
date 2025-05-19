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
                        <div class="w-full h-96 overflow-hidden rounded-t-lg">
                            <img src="{{ asset('images/tournament_banners/' . basename($tournament->banner)) }}" 
                                alt="{{ $tournament->name }} Banner"
                                class="w-full h-full object-cover">
                        </div>
                    @endif
                </div>
                
                <!-- Tournament Info -->
                <div class="md:w-1/3 bg-gray-800 p-6 rounded-lg">
                    <h1 class="text-2xl font-bold text-white mb-4">{{ $tournament->name }}</h1>
                    
                    <div class="space-y-4 text-gray-300">
                        <div class="flex items-center">
                            <i class="icofont-game-pad mr-2"></i>
                            <span>{{ $tournament->game }}</span>
                        </div>
                        
                        <div class="flex items-center">
                            <i class="icofont-users mr-2"></i>
                            <span>{{ $tournament->participants_count }} participantes</span>
                        </div>
                        
                        <div class="flex items-center">
                            <i class="icofont-group mr-2"></i>
                            <span>Máximo: {{ $tournament->max_participants }} participantes</span>
                        </div>
                        
                        @auth
                        <a href="#" class="block bg-blue-600 hover:bg-blue-700 text-white text-center py-2 rounded-lg mt-4">
                            Inscrever-se
                        </a>
                        @else
                        <a href="{{ route('login') }}" class="block bg-gray-600 hover:bg-gray-700 text-white text-center py-2 rounded-lg mt-4">
                            Faça login para participar
                        </a>
                        @endauth
                        @if (auth()->check() && auth()->id() === $tournament->user_id)
                        <div class="flex justify-end mb-4 space-x-2">
                            <button @click="editing = true"
                                    class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                                Editar Torneio
                            </button>

                            <form action="{{ route('tournaments.destroy', $tournament) }}" method="POST"
                                onsubmit="return confirm('Tem certeza que deseja excluir este torneio?');">
                                @csrf
                                @method('DELETE')
                                <button class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 transition">
                                    Excluir Torneio
                                </button>
                            </form>
                        </div>

                            <div x-data="{ editing: false }">
                            <!-- Modal de Edição -->
                            <div x-show="editing" x-cloak class="fixed inset-0 z-50 bg-black bg-opacity-70 flex items-center justify-center">
                                <div class="bg-gray-900 text-white rounded-lg shadow-lg p-6 w-full max-w-3xl">
                                    <h2 class="text-xl font-bold mb-4">Editar Torneio</h2>

                                    <form action="{{ route('tournaments.update', $tournament) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')

                                        <div class="space-y-4">

                                            <div>
                                                <label class="block mb-1">Nome do Torneio</label>
                                                <input type="text" name="name" value="{{ $tournament->name }}"
                                                    class="w-full rounded bg-gray-800 border border-gray-700 px-3 py-2 text-white">
                                            </div>

                                            <div>
                                                <label class="block mb-1">Descrição</label>
                                                <textarea name="description" rows="3"
                                                        class="w-full rounded bg-gray-800 border border-gray-700 px-3 py-2 text-white">{{ $tournament->description }}</textarea>
                                            </div>

                                            <div>
                                                <label class="block mb-1">Regras</label>
                                                <textarea name="rules" rows="4"
                                                        class="w-full rounded bg-gray-800 border border-gray-700 px-3 py-2 text-white">{{ $tournament->rules }}</textarea>
                                            </div>

                                            <div>
                                                <label class="block mb-1">Premiação</label>
                                                <textarea name="prizes" rows="3"
                                                        class="w-full rounded bg-gray-800 border border-gray-700 px-3 py-2 text-white">{{ $tournament->prizes }}</textarea>
                                            </div>

                                            <div>
                                                <label class="block mb-1">Banner</label>
                                                <label class="block cursor-pointer w-full">
                                                    <input type="file" name="banner" class="hidden" onchange="this.closest('label').nextElementSibling.src = window.URL.createObjectURL(this.files[0])">
                                                    <div class="border border-gray-700 rounded p-2 w-full text-center bg-gray-800 hover:bg-gray-700 transition">Clique para trocar a imagem</div>
                                                </label>
                                                <img src="{{ asset('storage/' . $tournament->banner) }}"
                                                    alt="Banner atual" class="mt-2 rounded max-h-48 object-cover w-full">
                                            </div>

                                        </div>

                                        <div class="mt-6 flex justify-between">
                                            <button type="button" @click="editing = false"
                                                    class="px-4 py-2 bg-gray-700 rounded hover:bg-gray-600">
                                                Cancelar
                                            </button>
                                            <button type="submit"
                                                    class="px-4 py-2 bg-green-600 rounded hover:bg-green-700">
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
            <button @click="tab = 'rules'" :class="tab === 'rules' ? 'border-b-2 border-white text-white' : 'text-gray-400'" class="pb-2 px-4 focus:outline-none">
                REGRAS
            </button>
            <button @click="tab = 'prizes'" :class="tab === 'prizes' ? 'border-b-2 border-white text-white' : 'text-gray-400'" class="pb-2 px-4 focus:outline-none">
                PREMIAÇÕES
            </button>
            <button @click="tab = 'contact'" :class="tab === 'contact' ? 'border-b-2 border-white text-white' : 'text-gray-400'" class="pb-2 px-4 focus:outline-none">
                DÚVIDAS
            </button>
        </div>

        <!-- Tab Contents -->
        <div x-show="tab === 'details'" class="text-gray-300 space-y-4">
            <h2 class="text-xl font-bold text-white">JOGO</h2>
            <p>{{ $tournament->game }}</p>

            <h2 class="text-xl font-bold text-white mt-6">DATA</h2>
            <p>{{ $tournament->start_date->format('l, F jS Y') }}</p>
            <p>{{ $tournament->start_date->format('g:i A T') }}</p>

            <h2 class="text-xl font-bold text-white mt-6">Format</h2>
            <p>{{ $tournament->format }}</p>
            <p>Pre-Made Team & Free Agent Registrations are allowed</p>

            <h2 class="text-xl font-bold text-white mt-6">Game Map & Type</h2>
            <p>{{ $tournament->map ?? 'Summoners Rift' }}</p>
            <p>{{ $tournament->type ?? 'Tournament Draft' }}</p>
        </div>

        <div x-show="tab === 'rules'" x-cloak class="text-gray-300 space-y-4">
            <h2 class="text-xl font-bold text-white mb-2">Regras</h2>
            <div class="prose prose-invert max-w-none">
                {!! nl2br(e($tournament->rules)) !!}
            </div>
        </div>

        <div x-show="tab === 'prizes'" x-cloak class="text-gray-300 space-y-4">
            <h2 class="text-xl font-bold text-white mb-2">Premiação</h2>
            <div class="prose prose-invert max-w-none">
                {!! nl2br(e($tournament->prizes)) !!}
            </div>
        </div>

        <div x-show="tab === 'contact'" x-cloak class="text-gray-300">
            <p>Para mais informações, entre em contato com a organização do evento.</p>
        </div>

    </div>

    </section>
@endsection