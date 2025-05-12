@extends('layouts.app')

@section('title', 'Meus Torneios')

@section('content')
    <!-- ===========Banner Section Start========== -->
    <!-- Styles -->
    <style>
        .banner-section {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
        }
    
        .carousel-wrapper {
        position: relative;
        height: 650px;
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
    
        /* Hide scrollbar across browsers */
        .compact-carousel::-webkit-scrollbar {
        display: none;
        }
    
        .compact-carousel {
        -ms-overflow-style: none; /* IE and Edge */
        scrollbar-width: none; /* Firefox */
        }
    
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
        }
    </style>
    
    <!-- Carousel Section -->
    <section class="pageheader-section" style="background-image: url(images/pageheader/bg.jpg);">

        <section class="banner-section">
            <div class="carousel-wrapper">
            <div class="compact-carousel">
                <!-- Slide 1 -->
                <div class="banner-slide">
                <img loading="lazy" src="{{ asset('images/banner/lol-banner.jpg') }}" alt="LoL Tournaments" />
                <div class="banner-caption">
                    <span class="banner-tag" style="background: #1DA1F2;">Featured</span>
                    <h3 class="banner-title">League of Legends</h3>
                    <p class="banner-description">Weekly tournaments with cash prizes</p>
                    <a href="/tournaments?game=League+of+Legends" class="banner-button" style="background: #1DA1F2;">Join Now</a>
                </div>
                </div>
        
                <!-- Slide 2 -->
                <div class="banner-slide">
                <img loading="lazy" src="{{ asset('images/banner/valorant-banner.jpg') }}" alt="Valorant Tournaments" />
                <div class="banner-caption">
                    <span class="banner-tag" style="background: #FF4655;">New Season</span>
                    <h3 class="banner-title">Valorant</h3>
                    <p class="banner-description">Prove your skills in ranked tournaments</p>
                    <a href="/tournaments?game=Valorant" class="banner-button" style="background: #FF4655;">Compete Now</a>
                </div>
                </div>
        
                <!-- Slide 3 -->
                <div class="banner-slide">
                <img loading="lazy" src="{{ asset('images/banner/cs2-banner.png') }}" alt="CS2 Tournaments" />
                <div class="banner-caption">
                    <span class="banner-tag" style="background: #F97803;">Premium</span>
                    <h3 class="banner-title">Counter-Strike 2</h3>
                    <p class="banner-description">Monthly $5,000 championship</p>
                    <a href="/tournaments?game=Counter-Strike+2" class="banner-button" style="background: #F97803;">Register Team</a>
                </div>
                </div>
            </div>
        
            <!-- Navigation Dots -->
            <div class="nav-dots">
                <button onclick="scrollToSlide(0)"></button>
                <button onclick="scrollToSlide(1)"></button>
                <button onclick="scrollToSlide(2)"></button>
            </div>
            </div>
        </section>
        <!-- ===========Banner Section End========== -->
    </section>    
    <!-- Script -->
    <script>
        
        function scrollToSlide(index) {
            const carousel = document.querySelector('.compact-carousel');
            carousel.scrollTo({
                left: carousel.clientWidth * index,
                behavior: 'smooth'
            });
        }

    
        // Auto-rotation
        let currentSlide = 0;
        setInterval(() => {
        currentSlide = (currentSlide + 1) % 3;
        scrollToSlide(currentSlide);
        }, 4000);
    </script>
@endsection