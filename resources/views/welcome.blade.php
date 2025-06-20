@extends('layouts.app')

@section('title', 'Página Principal') {{-- Changed title for clarity --}}

@section('content')
    <style>
        .banner-section {
            max-width: 1500px; /* ADJUSTED */
            margin: 40px auto; /* ADJUSTED for overall spacing */
            padding: 20px;
        }

        .carousel-wrapper {
            position: relative;
            height: 720px; /* ADJUSTED */
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .compact-carousel {
            height: 100%;
            display: flex;
            overflow-x: auto;
            scroll-snap-type: x mandatory;
            scroll-behavior: smooth;
            -webkit-overflow-scrolling: touch;
        }

        .compact-carousel::-webkit-scrollbar { display: none; }
        .compact-carousel { -ms-overflow-style: none; scrollbar-width: none; }

        .banner-slide {
            flex: 0 0 100%;
            scroll-snap-align: start;
            position: relative;
        }

        .banner-slide img {
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
            background: rgba(0,0,0,0.5); /* Added subtle background for readability */
            padding: 15px;
            border-radius: 8px;
        }

        .banner-tag {
            display: inline-block;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 14px;
            margin-bottom: 10px;
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
        }

        .nav-dots {
            position: absolute;
            bottom: 15px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            gap: 8px;
            z-index: 10;
        }

        .nav-dots button {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.5);
            border: none;
            cursor: pointer;
            padding: 0; /* Ensure button styles don't interfere with size */
            transition: background-color 0.3s ease; /* Smooth transition for active dot */
        }
        .nav-dots button.active { /* Style for the active dot */
            background: white;
        }

        /* NEW: Styles for Detailed Description Area */
        .detailed-game-description-container {
            margin-top: 25px;
            padding: 20px;
            background-color: #1c1c29; /* Dark background, adjust to your theme */
            border-radius: 8px;
            color: #e0e0e0;
            min-height: 120px; /* Adjust as needed */
            text-align: left;
            border: 1px solid #333;
        }

        .detailed-game-description-container h4 {
            font-size: 1.75em; /* ~28px */
            color: #ffffff;
            margin-bottom: 12px;
        }

        .detailed-game-description-container p {
            font-size: 1em; /* ~16px */
            line-height: 1.7;
            white-space: pre-line; /* Respect newlines in the description text */
        }
    </style>

    {{-- The pageheader-section might be for a background, ensure it doesn't conflict with banner-section sizing --}}
    <section class="pageheader-section" style="background-image: url(images/pageheader/bg.jpg);">
        <div class="container"> {{-- Added a container for better structure if pageheader is full-width --}}
            <section class="banner-section">
                <div class="carousel-wrapper">
                    <div class="compact-carousel">
                        
                        <div class="banner-slide"
                             data-game-title="Participe dos torneios e concorra a prêmios!"
                             data-detailed-description="Já pensou em competir, se divertir e ainda ganhar prêmios? Participe dos torneios da Fatec E-Sports Arena!">
                            <img loading="lazy" src="{{ asset('images/banner/FESA-banner.jpg') }}" alt="LoL Tournaments" />
                            <div class="banner-caption">
                                <span class="banner-tag" style="background: #1DA1F2;">Em Alta</span>
                                <h3 class="banner-title">Participe Já!</h3>
                                <p class="banner-description">Campeonatos semestrais dos seus jogos favoritos!</p>
                                <a href="/dashboard" class="banner-button" style="background: #1DA1F2;">Participe Já</a>
                            </div>
                        </div>

                        <div class="banner-slide"
                             data-game-title="League of Legends"
                             data-detailed-description="Domine o Rift em nossos torneios de League of Legends! Com batalhas 5v5 e fases de grupos playoffs emocionantes. Prepare suas melhores estratégias e campeões para concorrer a prêmios! Participe à batalha!">
                            <img loading="lazy" src="{{ asset('images/banner/lol-banner.jpg') }}" alt="LoL Tournaments" />
                            <div class="banner-caption">
                                <span class="banner-tag" style="background: #1DA1F2;">Campeonato</span>
                                <h3 class="banner-title">League of Legends</h3>
                                <p class="banner-description">Campeonatos semestrais de League of Legends!</p>
                                <a href="/dashboard?game=LOL" class="banner-button" style="background: #1DA1F2;">Cadastre-se Já</a>
                            </div>
                        </div>

                        <div class="banner-slide"
                             data-game-title="Valorant"
                             data-detailed-description="Mostre sua precisão tática nos campeonatos de Valorant! Participe em confrontos 5v5, ascenda nos rankings, desafie os melhores e conquiste recompensas exclusivas. Sua mira faz a diferença!">
                            <img loading="lazy" src="{{ asset('images/banner/valorant-banner.jpg') }}" alt="Valorant dashboard" />
                            <div class="banner-caption">
                                <span class="banner-tag" style="background: #FF4655;">Campeonato</span>
                                <h3 class="banner-title">Valorant</h3>
                                <p class="banner-description">Campeonatos semestrais de Valorant!</p>
                                <a href="/dashboard?game=VALORANT" class="banner-button" style="background: #FF4655;">Participe Agora</a>
                            </div>
                        </div>

                        <div class="banner-slide"
                             data-game-title="Counter-Strike 2"
                             data-detailed-description="Ação frenética e estratégia de ponta nos torneios de CS2! Monte sua equipe, refine suas táticas e dispute prêmios! A lenda do CS continua aqui!">
                            <img loading="lazy" src="{{ asset('images/banner/cs2-banner.png') }}" alt="CS2 dashboard" />
                            <div class="banner-caption">
                                <span class="banner-tag" style="background: #F97803;">Campeonato</span>
                                <h3 class="banner-title">Counter-Strike 2</h3>
                                <p class="banner-description">Campeonatos semestrais de Counter Strike 2!</p>
                                <a href="/dashboard?game=CS2" class="banner-button" style="background: #F97803;">Crie Sua Equipe</a>
                            </div>
                        </div>
                    </div>

                    <div class="nav-dots">
                        
                    </div>
                </div>

                <div id="detailed-game-description-area" class="detailed-game-description-container">
                    <h4 id="detailed-game-title">League of Legends</h4>
                    <p id="detailed-game-text">Domine o Rift em nossos torneios de League of Legends! Oferecemos formatos Solo/Duo e Equipes Fechadas 5v5, com fases de grupos e playoffs emocionantes. Prepare suas melhores estratégias e campeões para competir por prêmios incríveis e glória eterna. Junte-se à batalha!</p> {{-- Initial Description --}}
                </div>
            </section>
        </div>
    </section>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const carousel = document.querySelector('.compact-carousel');
            const slides = carousel.querySelectorAll('.banner-slide');
            const navDotsContainer = document.querySelector('.banner-section .nav-dots'); 

            const detailedGameTitleElement = document.getElementById('detailed-game-title');
            const detailedGameTextElement = document.getElementById('detailed-game-text');

            let currentSlideIndex = 0;
            let autoRotateInterval;

            function updateSlideDetails(index) {
                if (index < 0 || index >= slides.length) return;

                const activeSlide = slides[index];
                detailedGameTitleElement.textContent = activeSlide.dataset.gameTitle || '';
                detailedGameTextElement.textContent = activeSlide.dataset.detailedDescription || ''; 

                Array.from(navDotsContainer.children).forEach((dot, dotIndex) => {
                    dot.classList.toggle('active', dotIndex === index);
                });
                currentSlideIndex = index; 
            }

            window.scrollToSlide = function(index) { 
                if (index < 0 || index >= slides.length) return;
                carousel.scrollTo({
                    left: carousel.clientWidth * index,
                    behavior: 'smooth'
                });
                stopAutoRotation(); // Stop auto-rotation on manual navigation
            }

            // Generate Nav Dots
            slides.forEach((slide, index) => {
                const dot = document.createElement('button');
                dot.setAttribute('aria-label', `Go to slide ${index + 1}`);
                dot.onclick = () => scrollToSlide(index);
                navDotsContainer.appendChild(dot);
            });

            // Auto-rotation
            function startAutoRotation() {
                autoRotateInterval = setInterval(() => {
                    let nextSlideIndex = (currentSlideIndex + 1) % slides.length;
                    scrollToSlide(nextSlideIndex);
                }, 4000);
            }

            function stopAutoRotation() {
                clearInterval(autoRotateInterval);
            }

            // Intersection Observer to detect current slide
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        // Find the index of the intersecting slide
                        const intersectingSlide = entry.target;
                        const index = Array.from(slides).indexOf(intersectingSlide);
                        if (index !== -1) {
                            updateSlideDetails(index);
                        }
                    }
                });
            }, {
                root: carousel, // The carousel itself is the scrollable area
                threshold: 0.5  // Trigger when 50% of the slide is visible
            });

            slides.forEach(slide => {
                observer.observe(slide);
            });

            // Initial setup
            if (slides.length > 0) {
                updateSlideDetails(0); // Set initial description and dot
                startAutoRotation();

                // Stop auto-rotation on user interaction
                carousel.addEventListener('pointerdown', stopAutoRotation, { once: true }); // Stop once on first interaction
                carousel.addEventListener('wheel', stopAutoRotation, { once: true, passive: true });
                carousel.addEventListener('touchstart', stopAutoRotation, { once: true, passive: true });
            }
        });
    </script>
@endsection