<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Meus Torneios')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- All stylesheet and icons css  -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('css/icofont.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/swiper.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/lightcase.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.min.css') }}">

    @stack('styles') <!-- Optional: for page-specific styles -->
</head>

<body>
    <!-- preloader start here -->
    <div class="preloader">
        <div class="preloader-inner">
            <div class="preloader-icon">
                <span></span>
                <span></span>
            </div>
        </div>
    </div>
    <!-- preloader ending here -->

    <!-- scrollToTop start here -->
    <a href="{{ url("#") }}" class="scrollToTop"><i class="icofont-rounded-up"></i></a>
    <!-- scrollToTop ending here -->

    <!-- ==========shape image Starts Here========== -->
    <div class="body-shape">
        <img src="{{ asset("/images/shape/body-shape.png") }}" alt="shape">
    </div>
    <!-- ==========shape image end Here========== -->

    @include('layouts.header')

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    @include('layouts.footer')

    <script src="{{ asset("/js/vendor/jquery-3.6.0.min.js") }}"></script>
    <script src="{{ asset("/js/vendor/modernizr-3.11.2.min.js") }}"></script>
    <script src="{{ asset("/js/circularProgressBar.min.js") }}"></script>
    <script src="{{ asset("/js/isotope.pkgd.min.js") }}"></script>
    <script src="{{ asset("/js/swiper.min.js") }}"></script>
    <script src="{{ asset("/js/lightcase.js") }}"></script>
    <script src="{{ asset("/js/waypoints.min.js") }}"></script>
    <script src="{{ asset("/js/wow.min.js") }}"></script>
    <script src="{{ asset("/js/vendor/bootstrap.bundle.min.js") }}"></script>
    <script src="{{ asset("/js/plugins.js") }}"></script>
    <script src="{{ asset("/js/main.js") }}"></script>

    @stack('scripts') <!-- Optional: for page-specific scripts -->
</body>
</html>