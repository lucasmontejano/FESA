@extends('layouts.app')

@section('title', 'Convite para time')

@section('content')

@if(!$invite->isValid())
    <div class="alert alert-danger">
        This invite is no longer valid or the team is full
    </div>
@endif

<div class="container py-5" style="padding-top: 100px;">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="invitation-card">
                {{-- Team Header --}}
                <div class="team-header">
                    <div class="header-background"></div>
                    <div class="header-content">
                        @if($invite->team->picture)
                        <div class="team-logo-container">
                            <img src="{{ asset('images/team_pictures/' . $invite->team->picture) }}" 
                                 alt="{{ $invite->team->name }}"
                                 class="team-logo">
                        </div>
                        @endif
                        <h3 class="team-name">{{ $invite->team->name }}</h3>
                        <p class="invited-by">Convidado por {{ $invite->sender->name }}</p>
                        <div class="header-decoration"></div>
                    </div>
                </div>

                {{-- Invite Content --}}
                <div class="card-body">
                    <div class="invitation-icon">
                        <div class="icon-circle">
                            <i class="icofont-id-card"></i>
                        </div>
                    </div>
                    
                    <div class="invitation-title">
                        <h4>Convite para Equipe</h4>
                        <p class="expiration-info">
                            <i class="icofont-clock-time"></i>
                            Expira {{ $invite->expires_at->diffForHumans() }}
                        </p>
                    </div>

                    @guest
                        <div class="guest-section">
                            <div class="info-card">
                                <i class="icofont-info-circle"></i>
                                <p>Faça login para aceitar este convite</p>
                            </div>
                            <a href="{{ route('login') }}" class="btn-primary-custom">
                                <i class="icofont-login"></i>
                                <span>Fazer Login</span>
                            </a>
                        </div>
                    @endguest

                    @auth
                        @if($invite->team->members()->where('user_id', auth()->id())->exists())
                            <div class="member-section">
                                <div class="warning-card">
                                    <i class="icofont-info-circle"></i>
                                    <p>Você já é membro desta equipe</p>
                                </div>
                                <a href="{{ route('teams.show', $invite->team) }}" class="btn-secondary-custom">
                                    <i class="icofont-team"></i>
                                    <span>Ver Equipe</span>
                                </a>
                            </div>
                        @else
                            <div class="accept-section">
                                <form method="POST" action="{{ route('teams.acceptInvite', $invite->token) }}">
                                    @csrf
                                    <button type="submit" class="btn-accept">
                                        <i class="icofont-check-circled"></i>
                                        <span>Aceitar Convite</span>
                                    </button>
                                </form>
                            </div>
                        @endif
                    @endauth
                </div>

                {{-- Footer --}}
                <div class="card-footer">
                    <small>
                        <i class="icofont-info-circle"></i>
                        O convite expirará automaticamente
                    </small>
                </div>
            </div>

            {{-- Decorative Elements --}}
            <div class="floating-shapes">
                <div class="shape shape-1"></div>
                <div class="shape shape-2"></div>
                <div class="shape shape-3"></div>
            </div>
        </div>
    </div>
</div>

<style>
    :root {
        --primary-dark: #1a2332;
        --primary-blue: #2c3e50;
        --accent-pink: #e91e63;
        --accent-pink-light: #f48fb1;
        --accent-pink-dark: #c2185b;
        --gradient-primary: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary-blue) 100%);
        --gradient-pink: linear-gradient(135deg, var(--accent-pink) 0%, var(--accent-pink-dark) 100%);
        --gradient-accent: linear-gradient(135deg, var(--accent-pink-light) 0%, var(--accent-pink) 100%);
        --shadow-primary: 0 20px 40px rgba(26, 35, 50, 0.15);
        --shadow-hover: 0 25px 50px rgba(26, 35, 50, 0.25);
        --shadow-pink: 0 10px 30px rgba(233, 30, 99, 0.3);
    }

    .container {
        position: relative;
        z-index: 2;
    }

    .invitation-card {
        background: #1a1a1a;
        border-radius: 24px;
        box-shadow: var(--shadow-primary);
        overflow: hidden;
        position: relative;
        transform: translateY(0);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .invitation-card:hover {
        transform: translateY(-8px);
        box-shadow: var(--shadow-hover);
    }

    /* Header Styles */
    .team-header {
        position: relative;
        padding: 3rem 2rem 2rem;
        text-align: center;
        overflow: hidden;
    }

    .header-background {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: var(--gradient-primary);
    }

    .header-background::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: var(--gradient-pink);
        opacity: 0.1;
        background-size: 100px 100px;
        background-image: 
            radial-gradient(circle at 25% 25%, rgba(255,255,255,0.1) 2px, transparent 2px),
            radial-gradient(circle at 75% 75%, rgba(255,255,255,0.1) 2px, transparent 2px);
    }

    .header-content {
        position: relative;
        z-index: 2;
    }

    .team-logo-container {
        position: relative;
        display: inline-block;
        margin-bottom: 1.5rem;
    }

    .team-logo {
        width: 120px;
        height: 120px;
        object-fit: cover;
        border-radius: 50%;
        border: 4px solid rgba(255, 255, 255, 0.3);
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
        transition: transform 0.3s ease;
    }

    .team-logo:hover {
        transform: scale(1.05);
    }

    .team-name {
        color: white;
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
    }

    .invited-by {
        color: rgba(255, 255, 255, 0.8);
        font-size: 1rem;
        margin-bottom: 0;
        font-weight: 400;
    }

    .header-decoration {
        position: absolute;
        bottom: -1px;
        left: 0;
        right: 0;
        height: 30px;
        background: #1a1a1a;
        border-radius: 30px 30px 0 0;
    }

    /* Body Styles */
    .card-body {
        padding: 3rem 2.5rem 2rem;
        position: relative;
    }

    .invitation-icon {
        text-align: center;
        margin-bottom: 2rem;
    }

    .icon-circle {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 80px;
        height: 80px;
        background: var(--gradient-pink);
        border-radius: 50%;
        color: white;
        font-size: 2.5rem;
        box-shadow: var(--shadow-pink);
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.05); }
        100% { transform: scale(1); }
    }

    .invitation-title {
        text-align: center;
        margin-bottom: 2.5rem;
    }

    .invitation-title h4 {
        color: #ffffff;
        font-size: 1.8rem;
        font-weight: 700;
        margin-bottom: 1rem;
    }

    .expiration-info {
        color: #cccccc;
        font-size: 1rem;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
    }

    .expiration-info i {
        color: var(--accent-pink);
    }

    /* Guest Section */
    .guest-section {
        text-align: center;
    }

    .info-card {
        background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);
        border: 2px solid rgba(33, 150, 243, 0.2);
        border-radius: 16px;
        padding: 1.5rem;
        margin-bottom: 2rem;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 1rem;
    }

    .info-card i {
        color: #1976d2;
        font-size: 1.5rem;
    }

    .info-card p {
        margin: 0;
        color: #1976d2;
        font-weight: 500;
    }

    /* Warning Card */
    .warning-card {
        background: linear-gradient(135deg, #fff3e0 0%, #ffe0b2 100%);
        border: 2px solid rgba(255, 152, 0, 0.2);
        border-radius: 16px;
        padding: 1.5rem;
        margin-bottom: 2rem;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 1rem;
    }

    .warning-card i {
        color: #f57c00;
        font-size: 1.5rem;
    }

    .warning-card p {
        margin: 0;
        color: #f57c00;
        font-weight: 500;
    }

    /* Buttons */
    .btn-primary-custom,
    .btn-secondary-custom {
        display: inline-flex;
        align-items: center;
        gap: 0.75rem;
        padding: 1rem 2rem;
        border-radius: 50px;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .btn-primary-custom {
        background: var(--gradient-primary);
        color: white;
        box-shadow: 0 8px 25px rgba(26, 35, 50, 0.3);
    }

    .btn-primary-custom:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 35px rgba(26, 35, 50, 0.4);
        color: white;
        text-decoration: none;
    }

    .btn-secondary-custom {
        background: var(--gradient-pink);
        color: white;
        box-shadow: var(--shadow-pink);
    }

    .btn-secondary-custom:hover {
        transform: translateY(-2px);
        box-shadow: 0 15px 40px rgba(233, 30, 99, 0.4);
        color: white;
        text-decoration: none;
    }

    .btn-accept {
        width: 100%;
        background: var(--gradient-pink);
        border: none;
        padding: 1.25rem 2rem;
        border-radius: 50px;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 1rem;
        color: white;
        font-size: 1.2rem;
        font-weight: 700;
        box-shadow: var(--shadow-pink);
        position: relative;
        overflow: hidden;
    }

    .btn-accept::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg, var(--accent-pink-dark) 0%, #ad1457 100%);
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .btn-accept:hover::before {
        opacity: 1;
    }

    .btn-accept:hover {
        transform: translateY(-3px);
        box-shadow: 0 15px 40px rgba(233, 30, 99, 0.4);
    }

    .btn-accept i,
    .btn-accept span {
        position: relative;
        z-index: 1;
    }

    .btn-accept i {
        font-size: 1.5rem;
    }

    /* Footer */
    .card-footer {
        background: linear-gradient(135deg, #2a2a2a 0%, #1f1f1f 100%);
        padding: 1.5rem;
        text-align: center;
        border-top: 2px solid rgba(233, 30, 99, 0.1);
    }

    .card-footer small {
        color: #cccccc;
        font-weight: 500;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
    }

    .card-footer i {
        color: var(--accent-pink);
    }

    /* Floating Shapes */
    .floating-shapes {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        pointer-events: none;
        z-index: 1;
    }

    .shape {
        position: absolute;
        border-radius: 50%;
        background: var(--gradient-pink);
        opacity: 0.1;
        animation: float 6s ease-in-out infinite;
    }

    .shape-1 {
        width: 60px;
        height: 60px;
        top: 10%;
        left: -30px;
        animation-delay: 0s;
    }

    .shape-2 {
        width: 80px;
        height: 80px;
        top: 60%;
        right: -40px;
        animation-delay: 2s;
    }

    .shape-3 {
        width: 40px;
        height: 40px;
        bottom: 20%;
        left: 10%;
        animation-delay: 4s;
    }

    @keyframes float {
        0%, 100% { transform: translateY(0px) rotate(0deg); }
        50% { transform: translateY(-20px) rotate(180deg); }
    }

    /* Alert Overrides */
    .alert-danger {
        background: linear-gradient(135deg, #2d1b1b 0%, #3d1a1a 100%);
        border: 2px solid rgba(244, 67, 54, 0.3);
        border-radius: 16px;
        color: #ff6b6b;
        font-weight: 500;
        margin-bottom: 2rem;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .team-header {
            padding: 2rem 1.5rem 1.5rem;
        }
        
        .card-body {
            padding: 2rem 1.5rem 1.5rem;
        }
        
        .team-name {
            font-size: 1.5rem;
        }
        
        .team-logo {
            width: 100px;
            height: 100px;
        }
        
        .invitation-title h4 {
            font-size: 1.5rem;
        }
    }
</style>
@endsection