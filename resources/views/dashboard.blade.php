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
					<div class="header-top">
						<div class="header-top-area">
							<ul class="left">
								<li>
									<i class="icofont-ui-call"></i> <span>+55 (19) 3806-3139</span>
								</li>
								<li>
									<i class="icofont-location-pin"></i> Rua Ariovaldo Silveira Franco, 567
								</li>
							</ul>
							<ul class="social-icons d-flex align-items-center">
								<li>
									<a href="{{ url("#") }}" class="fb"><i class="icofont-facebook-messenger"></i></a>
								</li>
								<li>
									<a href="{{ url("#") }}" class="twitter"><i class="icofont-twitter"></i></a>
								</li>
								<li>
									<a href="{{ url("#") }}" class="vimeo"><i class="icofont-vimeo"></i></a>
								</li>
								<li>
									<a href="{{ url("#") }}" class="skype"><i class="icofont-skype"></i></a>
								</li>
								<li>
									<a href="{{ url("#") }}" class="rss"><i class="icofont-rss-feed"></i></a>
								</li>
							</ul>
						</div>
					</div>
					<div class="header-bottom">
						<div class="header-wrapper justify-content-lg-end">
							<div class="mobile-logo d-lg-none">
								<a href="{{ url("index.html") }}"><img src="{{ asset("/images/logo/logo.png") }}" alt="logo"></a>
							</div>
							<div class="menu-area">
								<ul class="menu">
									<li>
										<a href="{{ url("index.html") }}">Home</a>
									</li>

									<li>
										<a href="{{ url("#0") }}">Features</a>
										<ul class="submenu">
											<li><a href="{{ url("about.html") }}">About</a></li>
											<li><a href="{{ url("gallery.html") }}">gallery</a></li>
											<li>
												<a href="{{ url("#0") }}">games</a>
												<ul class="submenu">
													<li><a href="{{ url("game-list.html") }}">game list 1</a></li>
													<li><a href="{{ url("game-list2.html") }}">game list 2</a></li>
												</ul>
											</li>
											<li><a href="{{ url("partners.html") }}">partners</a></li>
											<li>
												<a href="{{ url("#0") }}">teams</a>
												<ul class="submenu">
													<li><a href="{{ url("team.html") }}">team</a></li>
													<li><a href="{{ url("team-single.html") }}">team single</a></li>
												</ul>
											</li>
											<li>
												<a href="{{ url("#0") }}" class="active">accounts</a>
												<ul class="submenu">
													<li><a href="{{ url("login.html") }}" class="active">login</a></li>
													<li><a href="{{ url("signup.html") }}">signup</a></li>
												</ul>
											</li>
											<li>
												<a href="{{ url("#0") }}">Shop</a>
												<ul class="submenu">
													<li><a href="{{ url("shop.html") }}">shop</a></li>
													<li><a href="{{ url("shop-single.html") }}">Shop Details</a></li>
													<li><a href="{{ url("cart-page.html") }}">Cart Page</a></li>
												</ul>
											</li>
											<li><a href="{{ url("404.html") }}">404 Page</a></li>

										</ul>
									</li>
									<li><a href="{{ url("achievements.html") }}">achievement</a></li>
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
								<a href="{{ url("login.html") }}" class="login"><i class="icofont-user"></i> <span>Login</span> </a>
								<a href="{{ url("signup.html") }}" class="signup"><i class="icofont-users"></i> <span>Cadastre-se</span></a>

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
    
    <!-- ===========Banner Section start Here========== -->
    <section class="pageheader-section" style="background-image: url(images/pageheader/bg.jpg);">
        <div class="container py-8">
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
                <div class="grid grid-cols-1 lg:grid-cols-{{ auth()->check() && auth()->user()->isAdmin() ? '4' : '1' }} gap-6">
                    <!-- Main Content Area -->
                    <div class="lg:col-span-3">
                        <!-- Tournaments Header -->
                        <div class="flex justify-between items-center mb-6">
                            <h2 class="text-3xl font-bold text-white">Torneios Ativos</h2>
                            <div class="relative">
                                <select class="bg-gray-800 text-white px-4 py-2 rounded-lg">
                                    <option>Filtrar por Jogo</option>
                                    <option>CS:GO</option>
                                    <option>League of Legends</option>
                                    <option>Valorant</option>
                                </select>
                            </div>
                        </div>
                        <div class="lg:col-span-{{ auth()->check() && auth()->user()->isAdmin() ? '3' : '1' }}">
                        <!-- Tournaments Grid -->
                            @if($errors->any())
                                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                                    <ul>
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            @if(session('success'))
                                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                                    {{ session('success') }}
                                </div>
                            @endif
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @forelse($tournaments as $tournament)
                                <div class="bg-gray-800 rounded-lg p-6 hover:bg-gray-700 transition">
                                    <div class="flex items-center mb-4">
                                        <img src="{{ $tournament->game_logo }}" alt="Game Logo" class="w-12 h-12 mr-4">
                                        <div>
                                            <h3 class="text-xl font-bold text-white">{{ $tournament->name }}</h3>
                                            <p class="text-gray-400">{{ $tournament->game }}</p>
                                        </div>
                                    </div>
                                    <div class="flex justify-between text-sm text-gray-400 mb-4">
                                        <div>
                                            <i class="icofont-calendar"></i>
                                            {{ $tournament->start_date }} - {{ $tournament->end_date }}
                                        </div>
                                        <div>
                                            <i class="icofont-users"></i>
                                            {{ $tournament->participants_count }} participantes
                                        </div>
                                    </div>
                                    <a href="/tournaments/{{ $tournament->id }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 block text-center">
                                        Ver Detalhes
                                    </a>
                                </div>
                                @empty
                                    <div class="col-span-full text-center py-8">
                                        <p class="text-gray-400 text-lg mb-4">Nenhum torneio encontrado no momento.</p>
                                        @auth
                                        @if(auth()->user()->isAdmin())
                                            <button onclick="toggleCreateForm()" 
                                                    class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg transition-colors">
                                                Criar Primeiro Torneio
                                            </button>
                                        @else
                                            <p class="text-gray-400">Verifique novamente mais tarde!</p>
                                        @endif
                                        @else
                                            <a href="{{ route('login') }}" 
                                            class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition-colors">
                                                Faça login para ver torneios
                                            </a>
                                        @endauth
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Admin Sidebar -->
                    @auth
                    @if(auth()->user()->isAdmin())
                        <div class="lg:col-span-1">
                        <div class="bg-gray-800 p-6 rounded-lg">
                        <h3 class="text-xl font-bold text-white mb-4">Painel do Administrador</h3>
                        <button onclick="toggleCreateForm()" class="bg-green-600 text-white w-full py-2 rounded-lg mb-4 hover:bg-green-700">
                            Criar Novo Torneio
                        </button>

                        <!-- Create Tournament Form (Initially Hidden) -->
                        <div id="createForm" class="hidden">
                            <form action="{{ route('tournaments.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="space-y-4">
                                    <input type="text" name="name" placeholder="Nome do Torneio" class="w-full bg-gray-700 text-white rounded-lg p-2">
                                    <input type="text" name="game" placeholder="Jogo" class="w-full bg-gray-700 text-white rounded-lg p-2">
                                    <input type="number" name="max_participants" placeholder="Número máximo de participantes" class="w-full bg-gray-700 text-white rounded-lg p-2" min="2" required>
                                    <input type="date" name="start_date" class="w-full bg-gray-700 text-white rounded-lg p-2">
                                    <input type="date" name="end_date" class="w-full bg-gray-700 text-white rounded-lg p-2">
                                    <textarea name="description" placeholder="Descrição" class="w-full bg-gray-700 text-white rounded-lg p-2"></textarea>
                                    <input type="file" name="banner" class="w-full text-white">
                                    <button type="submit" class="bg-blue-600 text-white w-full py-2 rounded-lg hover:bg-blue-700">
                                        Publicar Torneio
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    @endif
                    @endauth
                </div>
            </div>
        </div>
    </section>

    <script>
    function toggleCreateForm() {
        const form = document.getElementById('createForm');
        form.classList.toggle('hidden');
    }
    </script>
    <!-- ===========Banner Section Ends Here========== -->
	<section class="pageheader-section" style="background-image: url(images/pageheader/bg.jpg);">
        
        
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
