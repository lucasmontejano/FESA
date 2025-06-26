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
                            
                            <ul class="menu modern-menu">
                                
                                <li><a href="{{ url("/") }}" class="nav-link">Home</a></li>

                                <li><a href="{{ url("/rules") }}" class="nav-link">Regras da Plataforma</a></li>

                                <li>
                                    <a href="https://discord.gg/6VTfGxxPZp"
                                        target="_blank" 
                                        rel="noopener noreferrer"
                                        class="nav-link discord-link">
                                        <i class="icofont-brand-discord"></i>
                                        Discord
                                    </a>
                                </li>

                                <li>
                                    <a href="{{ url("dashboard") }}" class="nav-link">Torneios abertos</a>
                                </li>

                               <li>
                                    @auth
                                        <a href="{{ Auth::check() ? route('users.show', Auth::user()->name) : route('login') }}" class="nav-link profile-link">
                                            <i class="icofont-user-alt-3"></i>
                                            Perfil
                                        </a>
                                    @endauth
                                </li>    
                                
                            </ul>

                            <!-- Login and Signup Buttons -->
                            <div class="auth-buttons">
                                @guest
                                    <a href="{{ route('login') }}" class="btn-auth btn-login">
                                        <i class="icofont-lock"></i>
                                        <span>Login</span>
                                        <div class="btn-glow"></div>
                                    </a>

                                    <a href="{{ route('register') }}" class="btn-auth btn-register">
                                        <i class="icofont-user-plus"></i>
                                        <span>Cadastre-se</span>
                                        <div class="btn-glow"></div>
                                    </a>
                                @endguest

                                @auth
                                    <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn-auth btn-logout">
                                            <i class="icofont-logout"></i>
                                            <span>Logout</span>
                                            <div class="btn-glow"></div>
                                        </button>
                                    </form>
                                @endauth
                            </div>

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
    /* Header modernizado */
    .header-section {
        background: linear-gradient(135deg, #0e2349 10%, #3b182d 100%);
        backdrop-filter: blur(20px);
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        box-shadow: 0 4px 24px rgba(0, 0, 0, 0.1);
        position: relative;
        z-index: 1000;
    }

    .header-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(90deg, 
            rgba(59, 130, 246, 0.1) 0%, 
            rgba(147, 51, 234, 0.1) 50%, 
            rgba(236, 72, 153, 0.1) 100%);
        pointer-events: none;
    }

    .header-holder {
        position: relative;
        z-index: 2;
        padding: 1rem 0;
    }

    /* Logo styling */
    .brand-logo .logo a {
        display: inline-block;
        transition: transform 0.3s ease;
    }

    .brand-logo .logo a:hover {
        transform: scale(1.05);
    }

    /* Menu moderno */
    .modern-menu {
        display: flex;
        align-items: center;
        gap: 2rem;
        margin: 0;
        padding: 0;
        list-style: none;
    }

    .nav-link {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.75rem 1rem;
        border-radius: 12px;
        color: rgba(255, 255, 255, 0.9) !important;
        text-decoration: none !important;
        font-weight: 500;
        font-size: 0.95rem;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
    }

    .nav-link::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.1), transparent);
        transition: left 0.5s ease;
    }

    .nav-link:hover {
        color: #ffffff !important;
        background: rgba(255, 255, 255, 0.1);
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    }

    .nav-link:hover::before {
        left: 100%;
    }

    .discord-link:hover {
        background: linear-gradient(135deg, rgba(88, 101, 242, 0.2), rgba(88, 101, 242, 0.1));
        box-shadow: 0 8px 25px rgba(88, 101, 242, 0.3);
    }

    .profile-link:hover {
        background: linear-gradient(135deg, rgba(16, 185, 129, 0.2), rgba(16, 185, 129, 0.1));
        box-shadow: 0 8px 25px rgba(16, 185, 129, 0.3);
    }

    /* Botões de autenticação modernos */
    .auth-buttons {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-left: 2rem;
    }

    .btn-auth {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.75rem 1.5rem;
        border-radius: 16px;
        font-weight: 600;
        font-size: 0.9rem;
        text-decoration: none;
        border: none;
        cursor: pointer;
        position: relative;
        overflow: hidden;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        backdrop-filter: blur(10px);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    .btn-glow {
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        transition: left 0.6s ease;
    }

    .btn-auth:hover .btn-glow {
        left: 100%;
    }

    /* Botão de Login - Azul elegante */
    .btn-login {
        background: linear-gradient(135deg, #1e40af, #3b82f6);
        color: white;
        border: 1px solid rgba(59, 130, 246, 0.3);
    }

    .btn-login:hover {
        background: linear-gradient(135deg, #1d4ed8, #2563eb);
        transform: translateY(-3px);
        box-shadow: 0 12px 30px rgba(59, 130, 246, 0.4);
        color: white;
    }

    /* Botão de Cadastro - Verde vibrante */
    .btn-register {
        background: linear-gradient(135deg, #059669, #10b981);
        color: white;
        border: 1px solid rgba(16, 185, 129, 0.3);
    }

    .btn-register:hover {
        background: linear-gradient(135deg, #047857, #059669);
        transform: translateY(-3px);
        box-shadow: 0 12px 30px rgba(16, 185, 129, 0.4);
        color: white;
    }

    /* Botão de Logout - Vermelho sofisticado */
    .btn-logout {
        background: linear-gradient(135deg, #dc2626, #ef4444);
        color: white;
        border: 1px solid rgba(239, 68, 68, 0.3);
    }

    .btn-logout:hover {
        background: linear-gradient(135deg, #b91c1c, #dc2626);
        transform: translateY(-3px);
        box-shadow: 0 12px 30px rgba(239, 68, 68, 0.4);
        color: white;
    }

    .btn-auth:active {
        transform: translateY(-1px);
    }

    .btn-auth i {
        font-size: 1.1em;
        opacity: 0.9;
    }

    /* Animações suaves */
    @keyframes slideIn {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .header-section {
        animation: slideIn 0.5s ease-out;
    }

    /* Responsividade melhorada */
    @media (max-width: 991px) {
        .modern-menu {
            flex-direction: column;
            gap: 1rem;
        }
        
        .auth-buttons {
            margin-left: 0;
            margin-top: 1rem;
        }
        
        .btn-auth {
            padding: 0.6rem 1.2rem;
            font-size: 0.85rem;
        }
    }

    @media (max-width: 768px) {
        .auth-buttons {
            flex-direction: column;
            width: 100%;
        }
        
        .btn-auth {
            width: 100%;
            justify-content: center;
        }
    }

    /* Efeitos de micro-interação */
    .nav-link, .btn-auth {
        will-change: transform;
    }

    /* Melhoria no mobile menu toggle */
    .header-bar span {
        background: linear-gradient(135deg, #3b82f6, #10b981);
        border-radius: 2px;
        transition: all 0.3s ease;
    }

    .ellepsis-bar i {
        color: rgba(255, 255, 255, 0.8);
        font-size: 1.2em;
        transition: color 0.3s ease;
    }

    .ellepsis-bar:hover i {
        color: #3b82f6;
    }
</style>