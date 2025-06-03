<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Meus Torneios')</title>
    
    <!-- All stylesheet and icons css  -->
    <link rel="stylesheet" href="{{ asset('css/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('css/icofont.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/swiper.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/lightcase.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.min.css') }}">
    <link href="https://unpkg.com/cropperjs@1.5.13/dist/cropper.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="https://unpkg.com/brackets-viewer@latest/dist/brackets-viewer.min.css" />

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
    <script src="//unpkg.com/alpinejs" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.14.0/Sortable.min.js"></script>
    <script src="https://unpkg.com/cropperjs@1.5.13/dist/cropper.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/brackets-viewer@latest/dist/brackets-viewer.min.js"></script>

    @stack('scripts') <!-- Optional: for page-specific scripts -->

    @auth {{-- Only include this script if the user is authenticated and the link will be present --}}
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            const myTeamsHeaderLink = document.getElementById('headerLinkToMyTeamsTab');
            if (myTeamsHeaderLink) {
                myTeamsHeaderLink.addEventListener('click', function(event) {
                    // We are not preventing default navigation, just setting localStorage before it happens.
                    try {
                        localStorage.setItem('profilePage_targetTab', 'teams');
                    } catch (e) {
                        console.warn('Could not set localStorage item for profile tab:', e);
                        // If localStorage fails, the profile page will just open to its default tab.
                    }
                });
            }
        });
        </script>
    @endauth
</body>
</html>