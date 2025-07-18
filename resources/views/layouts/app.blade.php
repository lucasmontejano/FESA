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
    <link rel="stylesheet" href="https://unpkg.com/brackets-viewer@latest/dist/brackets-viewer.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.css" />
    
    <style>
        #bracket-container { /* Your main container for the bracket */
            /* Example: Set a max-width or other container styles if needed */
            /* background-color: #1e2030; /* Example: Darker background for the bracket area */
            padding: 20px;
            border-radius: 8px;
        }
        /* You can override library styles here if necessary, targeting its specific classes */
        /* For example, to match your dark theme: */
        .brackets-viewer .match .opponent .name, .brackets-viewer .match .opponent .result {
            color: #e0e0e0; /* Lighter text for team names/scores */
        }
        .brackets-viewer .match .opponent {
            background-color: #2d3748; /* Darker background for team boxes */
        }
        .brackets-viewer .match .opponent.winner .name, .brackets-viewer .match .opponent.winner .result {
            color: #68d391; /* Greenish for winner */
        }
        .brackets-viewer .round-title {
            color: #a0aec0; /* Lighter color for round titles */
        }
        .brackets-viewer .connector {
            border-color: #4a5568; /* Connector line color */
        }
    </style>

    @stack('styles') <!-- Optional: for page-specific styles -->
</head>

<body>
    {{-- <!-- preloader start here -->
    <div class="preloader">
        <div class="preloader-inner">
            <div class="preloader-icon">
                <span></span>
                <span></span>
            </div>
        </div>
    </div>
    <!-- preloader ending here --> --}}

    <!-- scrollToTop start here -->
    <a href="{{ url("#") }}" class="scrollToTop"><i class="icofont-rounded-up"></i></a>
    <!-- scrollToTop ending here -->

    <!-- ==========shape image Starts Here========== -->
    <div class="body-shape">
        <img src="{{ asset("/images/shape/body-shape.png") }}" alt="shape">
    </div>
    <!-- ==========shape image end Here========== -->

    @include('layouts.header')

    <main>  
        <div class="container mx-auto px-4 pt-24 py-6">
            @if (session('success'))
                <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show"
                    class="mt-4 p-3 bg-green-200 text-green-800 rounded-md">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                {{-- Para erros, damos um pouco mais de tempo para o usuário ler (ex: 7 segundos) --}}
                <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show"
                    class="mt-4 p-3 bg-red-200 text-red-800 rounded-md">
                    {{ session('error') }}
                </div>
            @endif

            @if (session('info'))
                <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show"
                    class="mt-4 p-3 bg-blue-200 text-blue-800 rounded-md">
                    {{ session('info') }}
                </div>
            @endif

            @if ($errors->any())
                <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show"
                    class="mt-4 p-3 bg-red-200 text-red-800 rounded-md">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
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
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/brackets-viewer@latest/dist/brackets-viewer.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.js"></script>

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