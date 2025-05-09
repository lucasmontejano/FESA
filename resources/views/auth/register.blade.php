<!doctype html>
<html class="no-js" lang="en">

<head>
	<meta charset="utf-8">
	<title>Big- Gamer Team Single</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- site favicon -->
	<link rel="icon" type="image/png" href="{{ asset("images/favicon.png") }}">
	<!-- Place favicon.ico in the root directory -->

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
		<div class="container">
            <div class="section-wrapper text-center text-uppercase">
                <h2 class="pageheader-title">Entre para competir</h2>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center mb-0">
                      <li class="breadcrumb-item"><a href="{{ url("index.html") }}">Home</a></li>
                      <li class="breadcrumb-item active" aria-current="page">Login</li>
                    </ol>
                </nav>
            </div>
		</div>
	</section>
	<!-- ===========Banner Section Ends Here========== -->



        <!-- Register Section Starts Here -->
    <div class="login-section padding-top padding-bottom">
        <div class="container">

            <!-- Success Message -->
            @if(session('success'))
                <div class="alert alert-success text-center">
                    {{ session('success') }}
                </div>
            @endif

            <div class="account-wrapper">
                <h3 class="title">Registrar</h3>

                <form class="account-form" id="register-form" method="POST" action="{{ route('register') }}">
                    @csrf <!-- Protects against CSRF attacks -->

                    <div class="form-group">
                        <input type="text" name="name" value="{{ old('name') }}" placeholder="Nome Completo" required autofocus>
                    </div>

                    <div class="form-group">
                        <input type="email" name="email" value="{{ old('email') }}" placeholder="E-mail" required>
                    </div>

                    <div class="form-group">
                        <input type="text" name="nickname" value="{{ old('nickname') }}" placeholder="Apelido" required>
                    </div>

                    <div class="form-group">
                        <input type="password" name="password" placeholder="Senha" required>
                    </div>

                    <div class="form-group">
                        <input type="password" name="password_confirmation" placeholder="Confirmar Senha" required>
                    </div>

                    <!-- Display errors -->
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="form-group">
                        <button type="submit" class="d-block default-button"><span>Criar Conta</span></button>
                    </div>

                    <div class="form-group text-center">
                        <p>Já tem uma conta? <a href="{{ route('login') }}">Login</a></p>
                    </div>
                </form>
            </div>

        </div>
    </div>



    <script>
        document.getElementById("show-register").addEventListener("click", function(event) {
            event.preventDefault();
            document.getElementById("login-form").style.display = "none";
            document.getElementById("register-form").style.display = "block";
        });
    
        document.getElementById("show-login").addEventListener("click", function(event) {
            event.preventDefault();
            document.getElementById("register-form").style.display = "none";
            document.getElementById("login-form").style.display = "block";
        });
    </script>


	<!-- ================ Footer Section start Here =============== -->
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
                                    <a href="https://www.google.com/maps/search/?api=1&query=Rua+Ariovaldo+Silveira+Franco,+567" 
                                       target="_blank" 
                                       style="text-decoration: none; color: inherit;">
                                        Rua Ariovaldo Silveira Franco, 567
                                    </a>
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







	<!-- All Needed JS -->
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