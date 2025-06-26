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

    <div class="login-section padding-top padding-bottom">
        <div class="container">
                <div class="account-wrapper">
                    <h3 class="title">Login</h3>
                    <form class="account-form" id="login-form" method="POST" action="{{ route('login') }}">
                        @csrf <!-- Protects against CSRF attacks -->
                
                        <div class="form-group">
                            <input type="text" placeholder="Usuário" name="email" required>
                        </div>
                        <div class="form-group">
                            <input type="password" placeholder="Senha" name="password" required>
                        </div>
                        <div class="form-group">
                            <div class="d-flex justify-content-between flex-wrap pt-sm-2">
                                <div class="checkgroup">
                                    <input type="checkbox" name="remember" id="remember">
                                    <label for="remember">Salvar login</label>
                                </div>
                                <a href="{{ route('password.request') }}">Esqueceu a senha?</a>
                            </div>
                        </div>
                
                        <div class="form-group">
                            <button type="submit" class="d-block default-button"><span>Entre Agora</span></button>
                        </div>
                
                        <div class="form-group text-center">
                            <p>Não tem uma conta? <a href="{{ route('register') }}">Registre-se</a></p>
                        </div>                        
                    </form>
                </div>
            </div>
        </div>
    </div>
<!-- Login Section Ends Here -->


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