@extends('layouts.app')

@section('title', 'Meus Torneios')

@section('content')
<style> 
    .pageheader-section {
        min-height: 10px;
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px 10px;
    }
    
</style>
	<section class="pageheader-section">
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

        <!-- Register Section Starts Here -->
    <div class="login-section padding-top padding-bottom">
        <div class="container">
            <div class="account-wrapper">
                <h3 class="title">Cadastre-se</h3>

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
@endsection