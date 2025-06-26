@extends('layouts.app')

@section('title', 'Regras da Plataforma')

@section('content')

<style> 
    .pageheader-section {
        min-height: 10px;
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px 10px;
    }
    
</style>
<div class="pageheader-section relative overflow-hidden" style="background: linear-gradient(135deg, #1c2738 0%, #101930 50%, #35143b 100%);">
    <div class="absolute inset-0 bg-gradient-to-r from-blue-900/20 to-pink-600/20"></div>
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-20 left-20 w-32 h-32 bg-pink-500 rounded-full blur-3xl"></div>
        <div class="absolute bottom-20 right-20 w-40 h-40 bg-blue-500 rounded-full blur-3xl"></div>
    </div>
    
    <div class="container mx-auto px-4 py-16 relative z-10">
        <div class="max-w-4xl mx-auto text-center">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-r from-pink-500 to-blue-600 rounded-full mb-6 shadow-lg">
                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <h1 class="text-5xl md:text-6xl font-bold text-white mb-6 bg-gradient-to-r from-pink-400 to-blue-400 bg-clip-text text-transparent">
                Nosso Código de Conduta
            </h1>
            <p class="text-xl text-gray-300 leading-relaxed max-w-3xl mx-auto">
                Acreditamos no poder do e-sport para unir pessoas. Nossas regras existem para garantir que cada partida, cada torneio e cada interação em nossa plataforma seja justa, respeitosa e, acima de tudo, divertida.
            </p>
        </div>
    </div>
</div>

<div class="py-16" style="background: linear-gradient(135deg, #102e5c 0%, #101930 50%, #380e36 100%)">
    <div class="max-w-4xl mx-auto px-4">

        <article class="prose prose-invert lg:prose-xl max-w-none text-gray-300">
            
            <div class="bg-gradient-to-r from-blue-900/30 to-pink-900/30 rounded-2xl p-8 mb-12 border border-blue-800/20 backdrop-blur-sm">
                <div class="flex items-center mb-4">
                    <div class="w-8 h-8 bg-gradient-to-r from-pink-500 to-blue-500 rounded-full flex items-center justify-center mr-3">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                        </svg>
                    </div>
                    <h2 class="text-3xl font-bold text-transparent bg-gradient-to-r from-pink-400 to-blue-400 bg-clip-text m-0">Nossa Filosofia</h2>
                </div>
                <p class="text-gray-300 text-lg leading-relaxed mb-0">
                    Nosso objetivo é mais do que apenas organizar torneios; é construir uma comunidade. Encorajamos a <strong class="text-pink-400">competitividade saudável</strong>, onde a busca pela vitória anda de mãos dadas com o respeito pelo oponente. Cada partida é uma oportunidade de aprender, melhorar e celebrar a paixão que todos nós compartilhamos pelos jogos.
                </p>
            </div>

            <div class="grid md:grid-cols-2 gap-8 mb-12">
                <!-- O Que Fazer -->
                <div class="bg-gradient-to-br from-green-900/20 to-blue-900/20 rounded-2xl p-8 border border-green-700/30">
                    <div class="flex items-center mb-6">
                        <div class="w-10 h-10 bg-gradient-to-r from-green-500 to-blue-500 rounded-full flex items-center justify-center mr-4">
                            <span class="text-2xl">✅</span>
                        </div>  
                        <h3 class="text-2xl font-bold text-green-400 m-0">O Que Fazer</h3>
                    </div>
                    <p class="text-gray-400 mb-6">Nossas Expectativas</p>
                    <ul class="space-y-4 text-gray-300">
                        <li class="flex items-start">
                            <div class="w-2 h-2 bg-pink-500 rounded-full mt-3 mr-3 flex-shrink-0"></div>
                            <div>
                                <strong class="text-blue-400">Seja Respeitoso:</strong> Trate todos os jogadores, equipes, administradores e espectadores com cortesia. Vitórias e derrotas fazem parte do jogo. Mantenha uma atitude positiva.
                            </div>
                        </li>
                        <li class="flex items-start">
                            <div class="w-2 h-2 bg-pink-500 rounded-full mt-3 mr-3 flex-shrink-0"></div>
                            <div>
                                <strong class="text-blue-400">Jogue Limpo:</strong> Compita com integridade. A vitória só tem valor quando é conquistada de forma justa.
                            </div>
                        </li>
                        <li class="flex items-start">
                            <div class="w-2 h-2 bg-pink-500 rounded-full mt-3 mr-3 flex-shrink-0"></div>
                            <div>
                                <strong class="text-blue-400">Seja Pontual:</strong> Respeite os horários das partidas. A pontualidade demonstra respeito pelo tempo dos seus oponentes e da organização.
                            </div>
                        </li>
                        <li class="flex items-start">
                            <div class="w-2 h-2 bg-pink-500 rounded-full mt-3 mr-3 flex-shrink-0"></div>
                            <div>
                                <strong class="text-blue-400">Comunique-se de Forma Clara:</strong> Use os canais de comunicação (como o Discord, se houver) de forma clara e construtiva para agendar partidas e resolver problemas.
                            </div>
                        </li>
                        <li class="flex items-start">
                            <div class="w-2 h-2 bg-pink-500 rounded-full mt-3 mr-3 flex-shrink-0"></div>
                            <div>
                                <strong class="text-blue-400">Etiqueta da Plataforma:</strong> Utilize do bom senso e crie seu perfil com base em dados reais, utilizando fotos para fácil identificação do integrante, e mantenha o respeito ao escolher o Nickname!
                            </div>
                        </li>
                    </ul>
                </div>

                <!-- O Que NÃO Fazer -->
                <div class="bg-gradient-to-br from-red-900/20 to-pink-900/20 rounded-2xl p-8 border border-red-700/30">
                    <div class="flex items-center mb-6">
                        <div class="w-10 h-10 bg-gradient-to-r from-red-500 to-pink-500 rounded-full flex items-center justify-center mr-4">
                            <span class="text-2xl">🚫</span>
                        </div>
                        <h3 class="text-2xl font-bold text-red-400 m-0">O Que NÃO Fazer</h3>
                    </div>
                    <p class="text-gray-400 mb-6">Tolerância Zero</p>
                    <p class="text-red-300 mb-6 text-sm bg-red-900/20 p-3 rounded-lg border border-red-700/30">
                        Qualquer uma das seguintes ações resultará em punições severas, incluindo a desqualificação imediata e o banimento da plataforma.
                    </p>
                    <ul class="space-y-4 text-gray-300">
                        <li class="flex items-start">
                            <div class="w-2 h-2 bg-red-500 rounded-full mt-3 mr-3 flex-shrink-0"></div>
                            <div>
                                <strong class="text-pink-400">Toxicidade e Assédio:</strong> Não toleramos qualquer forma de discurso de ódio, racismo, sexismo, homofobia, ameaças ou assédio pessoal.
                            </div>
                        </li>
                        <li class="flex items-start">
                            <div class="w-2 h-2 bg-red-500 rounded-full mt-3 mr-3 flex-shrink-0"></div>
                            <div>
                                <strong class="text-pink-400">Cheating (Trapaças):</strong> O uso de qualquer software de terceiros, hacks, scripts, exploits ou qualquer ferramenta que forneça uma vantagem injusta é estritamente proibido.
                            </div>
                        </li>
                        <li class="flex items-start">
                            <div class="w-2 h-2 bg-red-500 rounded-full mt-3 mr-3 flex-shrink-0"></div>
                            <div>
                                <strong class="text-pink-400">Manipulação de Resultados:</strong> Perder de propósito ou conspirar com outras equipes para manipular o resultado de uma partida é uma ofensa grave.
                            </div>
                        </li>
                        <li class="flex items-start">
                            <div class="w-2 h-2 bg-red-500 rounded-full mt-3 mr-3 flex-shrink-0"></div>
                            <div>
                                <strong class="text-pink-400">Múltiplas Contas (Smurfing):</strong> Cada jogador deve competir usando apenas sua conta principal. Jogar na conta de outra pessoa ou usar contas de nível mais baixo para obter vantagem é proibido.
                            </div>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="bg-gradient-to-r from-blue-900/30 to-purple-900/30 rounded-2xl p-8 border border-blue-700/30 backdrop-blur-sm">
                <div class="flex items-center mb-6">
                    <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-purple-500 rounded-full flex items-center justify-center mr-4">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                        </svg>
                    </div>
                    <h2 class="text-3xl font-bold text-transparent bg-gradient-to-r from-blue-400 to-purple-400 bg-clip-text m-0">Regras Específicas dos Torneios</h2>
                </div>
                <p class="text-gray-300 text-lg mb-4">
                    Cada torneio tem seu próprio conjunto de regras detalhadas, incluindo formato, mapas, configurações de lobby e procedimentos específicos do jogo. É responsabilidade de todos os jogadores ler e entender as regras do torneio em que estão inscritos.
                </p>
                <div class="bg-blue-900/20 rounded-lg p-4 border border-blue-700/30">
                    <p class="text-blue-300 mb-0">
                        💡 <strong>Dica:</strong> Você pode encontrar essas informações acessando a página do torneio e clicando nas abas <strong class="text-pink-400">"Regras"</strong>, <strong class="text-pink-400">"Descrição"</strong> e <strong class="text-pink-400">"Premiações"</strong>.
                    </p>
                </div>
            </div>

        </article>

    </div>
</div>
@endsection