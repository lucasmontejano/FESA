<!-- ==========Header Section Starts Here========== -->
<header class="header-section">
    <div class="container">
        <div class="header-holder d-flex flex-wrap justify-content-between align-items-center">
            <div class="brand-logo d-none d-lg-inline-block">
                <div class="logo">
                    <a href="{{ url("/") }}">
                        <img src="{{ asset("/images/logo/logo.png") }}" alt="logo" style="width: 160px; height: auto;">
                    </a>
                </div>
            </div>
            <div class="header-menu-part">
                <div class="header-bottom">
                    <div class="header-wrapper justify-content-lg-end">
                        <div class="mobile-logo d-lg-none">
                            <a href="{{ url("/") }}"><img src="{{ asset("/images/logo/logo.png") }}" alt="logo"></a>
                        </div>
                        <div class="menu-area">
                            <ul class="menu">
                                <li><a href="{{ url("/") }}">Home</a></li>

                                
                                <li>
                                    <a href="{{ url("dashboard") }}">Torneios</a>
                                </li>

                               <li>
                                    @auth
                                        <a href="{{ Auth::check() ? route('users.show', Auth::user()->name) : route('login') }}">Perfil</a>
                                    @endauth
                                </li>

                                <li>
                                    @auth
                                        <a href="{{ Auth::check() ? route('users.show', Auth::user()->name) : route('login') }}"
                                        id="headerLinkToMyTeamsTab" {{-- ADDED THIS ID --}}
                                        class="your-existing-header-link-styles"> {{-- Make sure to keep any existing classes --}}
                                            Meus Times
                                        </a>
                                    @endauth
                                </li>

                                
                            </ul>

                            <!-- Login and Signup Buttons -->
                            @guest
                                <a href="{{ route('login') }}" class="login" style="display: inline-flex; align-items: center; gap: 0.6rem; padding: 0.6rem 1.2rem; border-radius: 6px; background-color: rgba(255, 255, 255, 0.9); transition: all 0.3s ease; font-size: 1.05rem; position: relative; overflow: hidden; backdrop-filter: blur(4px); box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                                    <i class="icofont-users" style="background: linear-gradient(45deg, #3b82f6, #ec4899); -webkit-background-clip: text; background-clip: text; -webkit-text-fill-color: transparent; font-size: 1.2em;"></i>
                                    <span style="font-weight: 600; background: linear-gradient(45deg, #3b82f6, #ec4899); -webkit-background-clip: text; background-clip: text; -webkit-text-fill-color: transparent;">Login</span>
                                    <span style="position: absolute; inset: 0; background: linear-gradient(45deg, rgba(59, 130, 246, 0.2), rgba(236, 72, 153, 0.2)); opacity: 0; transition: opacity 0.3s ease;"></span>
                                </a>

                                <a href="{{ route('register') }}" class="signup" style="display: inline-flex; align-items: center; gap: 0.6rem; padding: 0.6rem 1.2rem; border-radius: 6px; background-color: rgba(224, 188, 206, 0.9); transition: all 0.3s ease; font-size: 1.05rem; position: relative; overflow: hidden; backdrop-filter: blur(4px); box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                                    <i class="icofont-user" style="background: linear-gradient(45deg, #3b82f6, #ec4899); -webkit-background-clip: text; background-clip: text; -webkit-text-fill-color: transparent; font-size: 1.2em;"></i>
                                    <span style="font-weight: 600; background: linear-gradient(45deg, #3b82f6, #ec4899); -webkit-background-clip: text; background-clip: text; -webkit-text-fill-color: transparent;">Cadastre-se</span>
                                    <span style="position: absolute; inset: 0; background: linear-gradient(45deg, rgba(59, 130, 246, 0.2), rgba(236, 72, 153, 0.2)); opacity: 0; transition: opacity 0.3s ease;"></span>
                                </a>
                            @endguest

                            @auth
                                <a href="{{ route('users.show', Auth::user()->name) }}" class="login" style="display: inline-flex; align-items: center; gap: 0.6rem; padding: 0.6rem 1.2rem; border-radius: 6px; background-color: rgba(255, 255, 255, 0.9); transition: all 0.3s ease; font-size: 1.05rem; position: relative; overflow: hidden; backdrop-filter: blur(4px); box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                                    <i class="icofont-ui-home" style="background: linear-gradient(45deg, #3b82f6, #ec4899); -webkit-background-clip: text; background-clip: text; -webkit-text-fill-color: transparent; font-size: 1.2em;"></i>
                                    <span style="font-weight: 600; background: linear-gradient(45deg, #3b82f6, #ec4899); -webkit-background-clip: text; background-clip: text; -webkit-text-fill-color: transparent;">Perfil</span>
                                    <span style="position: absolute; inset: 0; background: linear-gradient(45deg, rgba(59, 130, 246, 0.2), rgba(236, 72, 153, 0.2)); opacity: 0; transition: opacity 0.3s ease;"></span>
                                </a>

                                <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="signup" style="display: inline-flex; align-items: center; gap: 0.6rem; padding: 0.6rem 1.2rem; border-radius: 6px; background-color: rgba(224, 188, 206, 0.9); transition: all 0.3s ease; font-size: 1.05rem; position: relative; overflow: hidden; border: none; backdrop-filter: blur(4px); box-shadow: 0 2px 8px rgba(0,0,0,0.1); cursor: pointer;">
                                        <i class="icofont-logout" style="background: linear-gradient(45deg, #3b82f6, #ec4899); -webkit-background-clip: text; background-clip: text; -webkit-text-fill-color: transparent; font-size: 1.2em;"></i>
                                        <span style="font-weight: 600; background: linear-gradient(45deg, #3b82f6, #ec4899); -webkit-background-clip: text; background-clip: text; -webkit-text-fill-color: transparent;">Logout</span>
                                        <span style="position: absolute; inset: 0; background: linear-gradient(45deg, rgba(59, 130, 246, 0.2), rgba(236, 72, 153, 0.2)); opacity: 0; transition: opacity 0.3s ease;"></span>
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

<style>
    .login:hover, .signup:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }
    .login:hover span:last-child, .signup:hover span:last-child {
        opacity: 1;
    }
    .login:active, .signup:active {
        transform: translateY(0);
    }
</style>
<!-- ==========Header Section Ends Here========== -->