<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meus Torneios</title>
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- All stylesheet and icons css  -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('css/icofont.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/swiper.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/lightcase.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.min.css') }}">

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




	<!-- ==========Header Section Starts Here========== -->
	<header class="header-section">
        <div class="container">
            <div class="header-holder d-flex flex-wrap justify-content-between align-items-center">
                <div class="brand-logo d-none d-lg-inline-block">
                    <div class="logo">
                        <a href="{{ url("index.html") }}">
                            <img src="{{ asset("/images/logo/logo.png") }}" alt="logo" style="width: 160px; height: auto;">
                        </a>
                    </div>
                </div>
                <div class="header-menu-part">
                    <div class="header-bottom">
                        <div class="header-wrapper justify-content-lg-end">
                            <div class="mobile-logo d-lg-none">
                                <a href="{{ url("index.html") }}"><img src="{{ asset("/images/logo/logo.png") }}" alt="logo"></a>
                            </div>
                            <div class="menu-area">
                                <ul class="menu">
                                    <li><a href="{{ url("index.html") }}">Home</a></li>
    
                                    <li>
                                        <a href="{{ url("#0") }}">Features</a>
                                        <ul class="submenu">
                                            <li><a href="{{ url("about.html") }}">About</a></li>
                                            <li><a href="{{ url("gallery.html") }}">Gallery</a></li>
                                            <li>
                                                <a href="{{ url("#0") }}">Games</a>
                                                <ul class="submenu">
                                                    <li><a href="{{ url("game-list.html") }}">Game List 1</a></li>
                                                    <li><a href="{{ url("game-list2.html") }}">Game List 2</a></li>
                                                </ul>
                                            </li>
                                            <li><a href="{{ url("partners.html") }}">Partners</a></li>
                                            <li>
                                                <a href="{{ url("#0") }}">Teams</a>
                                                <ul class="submenu">
                                                    <li><a href="{{ url("team.html") }}">Team</a></li>
                                                    <li><a href="{{ url("team-single.html") }}">Team Single</a></li>
                                                </ul>
                                            </li>
                                            <li>
                                                <a href="{{ url("#0") }}" class="active">Accounts</a>
                                                <ul class="submenu">
                                                    @guest
                                                        <li><a href="{{ route('login') }}" class="active">Login</a></li>
                                                        <li><a href="{{ route('register') }}">Sign Up</a></li>
                                                    @endguest
                                                    @auth
                                                        <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
                                                        <li>
                                                            <form method="POST" action="{{ route('logout') }}">
                                                                @csrf
                                                                <button type="submit" class="btn btn-link" style="padding: 0; border: none; background: none; color: inherit;">
                                                                    Logout
                                                                </button>
                                                            </form>
                                                        </li>
                                                    @endauth
                                                </ul>
                                            </li>
                                            <li>
                                                <a href="{{ url("#0") }}">Shop</a>
                                                <ul class="submenu">
                                                    <li><a href="{{ url("shop.html") }}">Shop</a></li>
                                                    <li><a href="{{ url("shop-single.html") }}">Shop Details</a></li>
                                                    <li><a href="{{ url("cart-page.html") }}">Cart Page</a></li>
                                                </ul>
                                            </li>
                                            <li><a href="{{ url("404.html") }}">404 Page</a></li>
                                        </ul>
                                    </li>
    
                                    <li><a href="{{ url("achievements.html") }}">Achievement</a></li>
    
                                    <li>
                                        <a href="{{ url("#0") }}">Blog</a>
                                        <ul class="submenu">
                                            <li><a href="{{ url("blog.html") }}">Blog</a></li>
                                            <li><a href="{{ url("blog-2.html") }}">Blog 2</a></li>
                                            <li><a href="{{ url("blog-single.html") }}">Blog Single</a></li>
                                        </ul>
                                    </li>
    
                                    <li><a href="{{ url("contact.html") }}">Contact</a></li>
                                </ul>
    
                                <!-- Login and Signup Buttons -->
                                @guest
                                    <a href="{{ route('login') }}" class="login">
                                        <i class="icofont-user"></i> <span>Login</span>
                                    </a>
                                    <a href="{{ route('register') }}" class="signup">
                                        <i class="icofont-users"></i> <span>Cadastre-se</span>
                                    </a>
                                @endguest
    
                                @auth
                                    <a href="{{ route('dashboard') }}" class="login">
                                        <i class="icofont-ui-home"></i> <span>Dashboard</span>
                                    </a>
                                    <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="signup" style="background: none; border: none; color: inherit;">
                                            <i class="icofont-logout"></i> <span>Logout</span>
                                        </button>
                                    </form>
                                @endauth
    
                                <!-- toggle icons -->
                                <div class="header-bar d-lg-none">
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                </div>
                                <div class="ellepsis-bar d-lg-none">
                                    <i class="icofont-info-square"></i>
                                </div>
                            </div> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    
	<!-- ==========Header Section Ends Here========== -->
    


    <!-- ===========Banner Section start Here========== -->

    <section class="pageheader-section" style="background-image: url(images/pageheader/bg.jpg);">
        <div class="container mx-auto py-8">
            <!-- Tournament Header -->
            <div class="flex flex-col md:flex-row gap-6 mb-8">
                <!-- Tournament Banner -->
                <div class="md:w-2/3">
                    @if($tournament->banner)
                    <img src="{{ url('storage/' . $tournament->banner) }}" 
                        alt="{{ $tournament->name }} Banner"
                        class="w-full h-64 md:h-96 object-cover rounded-lg">
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
                            <i class="icofont-calendar mr-2"></i>
                            <span>{{ $tournament->start_date->format('d/m/Y') }} - {{ $tournament->end_date->format('d/m/Y') }}</span>
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
                    </div>
                </div>
            </div>
            
            <!-- Tournament Details -->
            <div class="bg-gray-800 rounded-lg p-6 mb-6">
                <h2 class="text-xl font-bold text-white mb-4">Descrição</h2>
                <div class="prose prose-invert max-w-none">
                    {!! nl2br(e($tournament->description)) !!}
                </div>
            </div>
            
            <!-- Tournament Rules -->
            <div class="bg-gray-800 rounded-lg p-6">
                <h2 class="text-xl font-bold text-white mb-4">Regras</h2>
                <div class="prose prose-invert max-w-none">
                    <!-- You could add a 'rules' field to your tournaments table -->
                    @if($tournament->rules)
                        {!! nl2br(e($tournament->rules)) !!}
                    @else
                        <p class="text-gray-400">Regras padrão do torneio serão aplicadas.</p>
                    @endif
                </div>
            </div>
        </div>
    </section>
    
	<!-- ===========Banner Section Ends Here========== -->




    <!-- ================ footer Section start Here =============== -->
    <footer class="footer-section">
        <div class="footer-top">
            <div class="container">
                <div class="row g-3 justify-content-center g-lg-0">
                    <div class="col-lg-4 col-sm-6 col-12">
                        <div class="footer-top-item lab-item">
                            <div class="lab-inner">
                                <div class="lab-thumb">
                                    <img src="{{ asset("/images/footer/icons/01.png") }}" alt="Phone-icon">
                                </div>
                                <div class="lab-content">
                                    <span>Telefone : +55 (19) 3806-2181</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-6 col-12">
                        <div class="footer-top-item lab-item">
                            <div class="lab-inner">
                                <div class="lab-thumb">
                                    <img src="{{ asset("/images/footer/icons/02.png") }}" alt="email-icon">
                                </div>
                                <div class="lab-content">
                                    <span>Email : lucas.zibordi@fatec.sp.gov.br</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-6 col-12">
                        <div class="footer-top-item lab-item">
                            <div class="lab-inner">
                                <div class="lab-thumb">
                                    <img src="{{ asset("/images/footer/icons/03.png") }}" alt="location-icon">
                                </div>
                                <div class="lab-content">
                                    <span>Endereço : Ariovaldo Silveira Franco, 567</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-middle padding-top padding-bottom" style="background-image: url(images/footer/bg.jpg);">
            <div class="container">
                <div class="row justify-content-center text-center padding-lg-top"> <!-- Centered Content -->
                    <div class="col-lg-4 col-md-6 col-12">
                        <div class="footer-middle-item-wrapper">
                            <div class="footer-middle-item mb-lg-0">
                                <div class="fm-item-title mb-4">
                                    <img src="{{ asset('/images/logo/logo-footer.png') }}" alt="logo-footer" style="width: 1000px; height: auto;">
                                </div>
                                <div class="fm-item-content">
                                    <p class="mb-4">
                                        Projeto desenvolvido para o trabalho de conclusão de curso, do curso de Análise e Desenvolvimento de Sistemas da FATEC Mogi Mirim.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </footer>
    <!-- ================ footer Section end Here =============== -->

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

</body>
</html>
