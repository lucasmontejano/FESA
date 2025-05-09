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
                        <a href="{{ url("") }}">
                            <img src="{{ asset("/images/logo/logo.png") }}" alt="logo" style="width: 160px; height: auto;">
                        </a>
                    </div>
                </div>
                <div class="header-menu-part">
                    <div class="header-bottom">
                        <div class="header-wrapper justify-content-lg-end">
                            <div class="mobile-logo d-lg-none">
                                <a href="{{ url("") }}"><img src="{{ asset("/images/logo/logo.png") }}" alt="logo"></a>
                            </div>
                            <div class="menu-area">
                                <ul class="menu">
                                    <li><a href="{{ url("") }}">Home</a></li>
    
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
  
  <!-- ===========Banner Section End========== -->
  




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
