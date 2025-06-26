@extends('layouts.app')

@section('title', 'Página Principal')

@section('content')
    <style>
        /* Hero Section with Game Cards */
        .hero-section {
            background: linear-gradient(135deg, #0e2349 10%, #3b182d 100%);
            padding: 80px 0 40px;
            position: relative;
            overflow: hidden;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(233, 30, 99, 0.1) 0%, rgba(233, 30, 99, 0.05) 100%);
            z-index: 1;
        }

        .hero-content {
            position: relative;
            z-index: 2;
        }

        .hero-title {
            text-align: center;
            color: white;
            margin-bottom: 60px;
        }

        .hero-title h1 {
            font-size: 3.5rem;
            font-weight: 800;
            margin-bottom: 20px;
            background: linear-gradient(135deg, #ffffff 0%, #e91e63 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hero-title p {
            font-size: 1.3rem;
            color: rgba(255, 255, 255, 0.8);
            max-width: 600px;
            margin: 0 auto;
        }

        .games-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 30px;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .game-card {
            position: relative;
            height: 280px;
            border-radius: 20px;
            overflow: hidden;
            cursor: pointer;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        }

        .game-card:hover {
            transform: translateY(-10px) scale(1.02);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
        }

        .game-card img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.4s ease;
        }

        .game-card:hover img {
            transform: scale(1.1);
        }

        .game-card-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, rgba(0, 0, 0, 0.7) 0%, rgba(0, 0, 0, 0.3) 100%);
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            padding: 25px;
            transition: background 0.3s ease;
        }

        .game-card:hover .game-card-overlay {
            background: linear-gradient(45deg, rgba(233, 30, 99, 0.8) 0%, rgba(233, 30, 99, 0.4) 100%);
        }

        .game-card-title {
            color: white;
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 10px;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.5);
        }

        .game-card-description {
            color: rgba(255, 255, 255, 0.9);
            font-size: 1rem;
            line-height: 1.5;
            margin-bottom: 15px;
        }

        .game-card-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: linear-gradient(135deg, #e91e63 0%, #c2185b 100%);
            color: white;
            padding: 12px 24px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(233, 30, 99, 0.3);
            align-self: flex-start;
        }

        .game-card-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(233, 30, 99, 0.4);
            color: white;
            text-decoration: none;
        }

        /* Banner and FAQ Section */

        .full-width-section {
            width: 100%;
            background-color: #f8f9fa; /* Exemplo de cor de fundo, ajuste como preferir */
            padding: 20px 20px; /* Padding vertical e um pequeno padding horizontal para telas pequenas */
        }

        .container {
            max-width: 1800px; /* A largura máxima que você queria */
            margin: 0 auto;    /* Centraliza o contêiner */
        }

        .banner-faq-section {
            max-width: 1800px;
            margin: -160px auto 20px;
            padding: 20px;
        }

        .section-title {
            text-align: center;
            margin-bottom: 20px;
        }

        .section-title h2 {
            font-size: 2.5rem;
            font-weight: 700;
            background: linear-gradient(135deg, #ffffff 0%, #e91e63 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 15px;
        }

        .section-title p {
            font-size: 1.3rem;
            color: rgba(255, 255, 255, 0.8);
            max-width: 600px;
            margin: 0 auto;
        }

        .banner-faq-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 40px;
            align-items: start;
        }

        .banner-container {
            position: relative;
            width: 100%; /* Ocupa 100% da coluna da grade */
            padding-top: 56.25%; /* Proporção de 16:9 (altura é 56.25% da largura) - AJUSTE SE NECESSÁRIO */
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        /* A imagem agora preenche o contêiner de forma absoluta */
        .banner-container img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .banner-caption {
            position: absolute;
            bottom: 30px;
            left: 30px;
            right: 30px;
            max-width: 500px;
            color: white;
            background: rgba(0,0,0,0.5);
            padding: 15px;
            border-radius: 8px;
        }

        .banner-tag {
            display: inline-block;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 14px;
            margin-bottom: 10px;
            background: #1DA1F2;
        }

        .banner-title {
            font-size: 28px;
            font-weight: 700;
            margin: 0 0 10px;
        }

        .banner-description {
            margin: 0 0 15px;
            font-size: 16px;
        }

        .banner-button {
            display: inline-block;
            padding: 8px 20px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 500;
            color: white;
            background: #1DA1F2;
        }

        .banner-button:hover {
            color: white;
            text-decoration: none;
        }

        .detailed-game-description-container {
            margin-top: 25px;
            padding: 25px;
            background: linear-gradient(135deg, #0e2349 10%, #3b182d 100%);
            border-radius: 12px;
            color: #e0e0e0;
            min-height: 120px;
            text-align: left;
            border: 2px solid rgba(233, 30, 99, 0.2);
        }

        .detailed-game-description-container h4 {
            font-size: 1.75em;
            color: #ffffff;
            margin-bottom: 12px;
        }

        .detailed-game-description-container p {
            font-size: 1em;
            line-height: 1.7;
            white-space: pre-line;
        }

        /* FAQ Styles */
        .faq-container {
            background: linear-gradient(135deg, #3b182d 10%, #0e2349 100%);
            border-radius: 20px;
            padding: 40px 30px;
            position: relative;
            overflow: hidden;
        }

        .faq-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(233, 30, 99, 0.05) 0%, rgba(233, 30, 99, 0.02) 100%);
            z-index: 1;
        }

        .faq-content {
            position: relative;
            z-index: 2;
        }

        .faq-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .faq-header h3 {
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 15px;
            background: linear-gradient(135deg, #ffffff 0%, #e91e63 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .faq-header p {
            font-size: 1.1rem;
            color: rgba(255, 255, 255, 0.8);
            max-width: 400px;
            margin: 0 auto;
        }

        .faq-list {
            display: grid;
            gap: 20px;
        }

        .faq-item {
            background: linear-gradient(135deg, rgba(26, 35, 50, 0.9) 0%, rgba(44, 62, 80, 0.8) 100%);
            border-radius: 15px;
            overflow: hidden;
            border: 2px solid rgba(233, 30, 99, 0.2);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .faq-item:hover {
            border-color: rgba(233, 30, 99, 0.4);
            transform: translateY(-2px);
        }

        .faq-item.active {
            border-color: #e91e63;
        }

        .faq-question {
            padding: 20px;
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: transparent;
            border: none;
            color: #ffffff;
            font-size: 1rem;
            font-weight: 600;
            text-align: left;
            width: 100%;
            transition: all 0.3s ease;
        }

        .faq-question:hover {
            color: #e91e63;
        }

        .faq-question .question-text {
            flex: 1;
            margin-right: 15px;
        }

        .faq-icon {
            font-size: 1.2rem;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            color: #e91e63;
        }

        .faq-item.active .faq-icon {
            transform: rotate(180deg);
        }

        .faq-answer {
            max-height: 0;
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            background: linear-gradient(135deg, rgba(233, 30, 99, 0.1) 0%, rgba(233, 30, 99, 0.05) 100%);
        }

        .faq-item.active .faq-answer {
            max-height: 400px;
        }

        .faq-answer-content {
            padding: 0 20px 20px;
            color: rgba(255, 255, 255, 0.9);
            line-height: 1.6;
            font-size: 0.9rem;
        }

        .faq-answer-content strong {
            color: #ffffff;
            font-weight: 600;
        }

        .faq-cta {
            text-align: center;
            margin-top: 30px;
            padding: 25px;
            background: linear-gradient(135deg, rgba(233, 30, 99, 0.1) 0%, rgba(233, 30, 99, 0.05) 100%);
            border-radius: 15px;
            border: 2px solid rgba(233, 30, 99, 0.2);
        }

        .faq-cta h4 {
            font-size: 1.5rem;
            margin-bottom: 10px;
            color: #ffffff;
        }

        .faq-cta p {
            font-size: 1rem;
            color: rgba(255, 255, 255, 0.8);
            margin-bottom: 20px;
        }

        .faq-cta-button {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: linear-gradient(135deg, #e91e63 0%, #c2185b 100%);
            color: white;
            padding: 12px 25px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(233, 30, 99, 0.3);
        }

        .faq-cta-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(233, 30, 99, 0.4);
            color: white;
            text-decoration: none;
        }

        /* Floating Animation */
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }

        .hero-section .games-grid .game-card:nth-child(1) {
            animation: float 6s ease-in-out infinite;
            animation-delay: 0s;
        }

        .hero-section .games-grid .game-card:nth-child(2) {
            animation: float 6s ease-in-out infinite;
            animation-delay: 2s;
        }

        .hero-section .games-grid .game-card:nth-child(3) {
            animation: float 6s ease-in-out infinite;
            animation-delay: 4s;
        }

        /* Responsive Design */
        @media (max-width: 1200px) {
            .banner-faq-grid {
                grid-template-columns: 1fr;
                gap: 30px;
            }
            
            .banner-container {
                height: 400px;
            }
        }

        @media (max-width: 768px) {
            .hero-title h1 {
                font-size: 2.5rem;
            }

            .games-grid {
                grid-template-columns: 1fr;
                gap: 20px;
                padding: 0 15px;
            }

            .game-card {
                height: 250px;
            }

            .section-title h2 {
                font-size: 2rem;
            }

            .banner-container {
                height: 350px;
            }

            .faq-header h3 {
                font-size: 2rem;
            }

            .faq-question {
                padding: 15px;
                font-size: 0.95rem;
            }

            .faq-answer-content {
                padding: 0 15px 15px;
            }
        }

        /* Background Decorations */
        .hero-section::after {
            content: '';
            position: absolute;
            top: 10%;
            right: -50px;
            width: 200px;
            height: 200px;
            background: linear-gradient(135deg, rgba(233, 30, 99, 0.1) 0%, rgba(233, 30, 99, 0.05) 100%);
            border-radius: 50%;
            z-index: 1;
        }
    </style>

    {{-- Hero Section with Game Cards --}}
    <section class="hero-section">
        <div class="container">
            <div class="hero-content">
                <div class="hero-title">
                    <h1>FATEC E-SPORTS ARENA</h1>
                    <p>Participe dos melhores torneios e mostre suas habilidades nos jogos mais populares!</p>
                </div>

                <div class="games-grid">
                    <div class="game-card" onclick="window.location.href='/dashboard?game=LOL'">
                        <img src="{{ asset('images/games/lol-card.jpg') }}" alt="League of Legends" loading="lazy">
                        <div class="game-card-overlay">
                            <h3 class="game-card-title">League of Legends</h3>
                            <p class="game-card-description">Domine o Rift com estratégias épicas e batalhas 5v5 emocionantes.</p>
                            <a href="/dashboard?game=LOL" class="game-card-btn">
                                <i class="icofont-game-controller"></i>
                                <span>Participar</span>
                            </a>
                        </div>
                    </div>

                    <div class="game-card" onclick="window.location.href='/dashboard?game=VALORANT'">
                        <img src="{{ asset('images/games/valorant-card.jpg') }}" alt="Valorant" loading="lazy">
                        <div class="game-card-overlay">
                            <h3 class="game-card-title">Valorant</h3>
                            <p class="game-card-description">Precisão tática e estratégia em combates 5v5 intensos.</p>
                            <a href="/dashboard?game=VALORANT" class="game-card-btn">
                                <i class="icofont-aim"></i>
                                <span>Competir</span>
                            </a>
                        </div>
                    </div>

                    <div class="game-card" onclick="window.location.href='/dashboard?game=CS2'">
                        <img src="{{ asset('images/games/cs2-card.jpg') }}" alt="Counter-Strike 2" loading="lazy">
                        <div class="game-card-overlay">
                            <h3 class="game-card-title">Counter-Strike 2</h3>
                            <p class="game-card-description">A lenda continua com ação frenética e estratégias de elite.</p>
                            <a href="/dashboard?game=CS2" class="game-card-btn">
                                <i class="icofont-target"></i>
                                <span>Jogar</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Banner and FAQ Section --}}
    <section class="pageheader-section" style="background-image: url(images/pageheader/bg.jpg);">
        <div class="container">
            <section class="banner-faq-section">
                <div class="section-title">
                    <h2>Dúvidas?</h2>
                    <p>Sessão de dúvidas frequentes</p>
                </div>

                <div class="banner-faq-grid">
                    {{-- Banner Container --}}
                    <div class="banner-side">
                        <div class="banner-container">
                            <img loading="lazy" src="{{ asset('images/banner/FESA-banner.jpg') }}" alt="FESA Tournaments" />
                            <div class="banner-caption">
                                <span class="banner-tag">Em Alta</span>
                                <h3 class="banner-title">Participe Já!</h3>
                                <p class="banner-description">Campeonatos semestrais dos seus jogos favoritos!</p>
                                <a href="/dashboard" class="banner-button">Participe Já</a>
                            </div>
                        </div>

                        <div class="detailed-game-description-container">
                            <h4>Participe dos torneios e concorra a prêmios!</h4>
                            <p>Já pensou em competir, se divertir e ainda ganhar prêmios? Participe dos torneios da Fatec E-Sports Arena!</p>
                        </div>
                    </div>

                    {{-- FAQ Container --}}
                    <div class="faq-container">
                        <div class="faq-content">
                            <div class="faq-header">
                                <h3>FAQ</h3>
                                <p>Dúvidas sobre como competir?</p>
                            </div>

                            <div class="faq-list">
                                <div class="faq-item">
                                    <button class="faq-question">
                                        <span class="question-text">Como funciona a inscrição?</span>
                                        <i class="icofont-simple-down faq-icon"></i>
                                    </button>
                                    <div class="faq-answer">
                                        <div class="faq-answer-content">
                                            <p><strong>1.</strong> Cadastre-se na plataforma<br>
                                            <strong>2.</strong> Crie ou entre para uma equipe<br>
                                            <strong>3.</strong> Convide seus amigos para a equipe (de 5-7 jogadores)<br>
                                            <strong>4.</strong> Inscreva a equipe no torneio</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="faq-item">
                                    <button class="faq-question">
                                        <span class="question-text">Qual o custo para participar?</span>
                                        <i class="icofont-simple-down faq-icon"></i>
                                    </button>
                                    <div class="faq-answer">
                                        <div class="faq-answer-content">
                                            <p><strong>A participação é totalmente gratuita!</strong> Nosso objetivo é fomentar a comunidade e a competição saudável.</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="faq-item">
                                    <button class="faq-question">
                                        <span class="question-text">Em quais jogos posso competir?</span>
                                        <i class="icofont-simple-down faq-icon"></i>
                                    </button>
                                    <div class="faq-answer">
                                        <div class="faq-answer-content">
                                            <p>No momento, temos 3 jogos disponíveis: <br>
                                            <strong>League of Legends:</strong> Batalhas 5v5 épicas<br>
                                            <strong>Valorant:</strong> Precisão tática em combates intensos<br>
                                            <strong>Counter-Strike 2:</strong> Ação frenética e estratégias de elite<br>
                                            <strong>Mais jogos em breve!</strong></p>
                                        </div>
                                    </div>
                                </div>

                                <div class="faq-item">
                                    <button class="faq-question">
                                        <span class="question-text">Quais as regras dos torneios?</span>
                                        <i class="icofont-simple-down faq-icon"></i>
                                    </button>
                                    <div class="faq-answer">
                                        <div class="faq-answer-content">
                                            <p>Cada torneio possui um <strong>livro de regras</strong> diferente, portanto basta conferir na aba de <strong>"Regras"</strong> na página do torneio!</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="faq-item">
                                    <button class="faq-question">
                                        <span class="question-text">E se eu não tiver uma equipe?</span>
                                        <i class="icofont-simple-down faq-icon"></i>
                                    </button>
                                    <div class="faq-answer">
                                        <div class="faq-answer-content">
                                            <p>Use nossa <strong>comunidade do Discord</strong> para encontrar companheiros!</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="faq-cta">
                                <h4>Preparado para competir?</h4>
                                <a href="/dashboard" class="faq-cta-button">
                                    <i class="icofont-rocket-alt-2"></i>
                                    <span>Comece Agora</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const faqItems = document.querySelectorAll('.faq-item');
            
            faqItems.forEach(item => {
                const question = item.querySelector('.faq-question');
                
                question.addEventListener('click', () => {
                    const isActive = item.classList.contains('active');
                    
                    // Fechar todas as outras perguntas
                    faqItems.forEach(otherItem => {
                        if (otherItem !== item) {
                            otherItem.classList.remove('active');
                        }
                    });
                    
                    // Toggle da pergunta atual
                    if (isActive) {
                        item.classList.remove('active');
                    } else {
                        item.classList.add('active');
                    }
                });
            });

            // Abrir a primeira pergunta por padrão
            if (faqItems.length > 0) {
                faqItems[0].classList.add('active');
            }
        });
    </script>
@endsection