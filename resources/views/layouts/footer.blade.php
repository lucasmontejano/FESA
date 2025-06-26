<!-- ================ footer Section start Here =============== -->
<footer class="footer-section" style="clear: both; position: relative; z-index: 1;">
    <div class="footer-top">
        <div class="container">
            <div class="row g-3 justify-content-center g-lg-0">
                <div class="col-lg-4 col-sm-6 col-12">
                    <div class="footer-top-item lab-item">
                        <div class="lab-inner">
                            <div class="lab-thumb">
                                <img src="{{ asset('/images/footer/icons/01.png') }}" alt="Phone-icon" style="max-width: 100%; height: auto;">
                            </div>
                            <div class="lab-content">
                                <span>Telefone : (19)3806-2181 ou (19)3806-3139</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6 col-12">
                    <div class="footer-top-item lab-item">
                        <div class="lab-inner">
                            <div class="lab-thumb">
                                <img src="{{ asset('/images/footer/icons/02.png') }}" alt="email-icon" style="max-width: 100%; height: auto;">
                            </div>
                            <div class="lab-content">
                                <span>Email : f163acad@cps.sp.gov.br</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6 col-12">
                    <div class="footer-top-item lab-item">
                        <div class="lab-inner">
                            <div class="lab-thumb">
                                <img src="{{ asset('/images/footer/icons/03.png') }}" alt="location-icon" style="max-width: 100%; height: auto;">
                            </div>
                            <div class="lab-content">
                                <span>
                                    <a href="https://www.google.com/maps/search/?api=1&query=Ariovaldo+Silveira+Franco+567"
                                     target="_blank"
                                     rel="noopener noreferrer"
                                     style="text-decoration: none; color: inherit; cursor: pointer; word-break: break-word;">
                                    Endereço : Ariovaldo Silveira Franco, 567
                                    </a>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="footer-middle padding-top padding-bottom" style="background-image: url('{{ asset('images/footer/bg.jpg') }}'); background-size: cover; background-position: center; background-repeat: no-repeat;">
        <div class="container">
            <div class="row justify-content-center text-center padding-lg-top">
                <div class="col-lg-8 col-md-10 col-12"> <!-- Aumentei a largura para acomodar melhor o logo -->
                    <div class="footer-middle-item-wrapper">
                        <div class="footer-middle-item mb-lg-0">
                            <div class="fm-item-title mb-4">
                                <img src="{{ asset('/images/logo/logo-footer.png') }}" 
                                     alt="logo-footer" 
                                     style="max-width: 1050px; width: 100%; height: auto; max-height: 525px; object-fit: contain;">
                            </div>
                            <div class="fm-item-content">
                                <p class="mb-4" style="line-height: 1.6; word-wrap: break-word;">
                                    Projeto desenvolvido para o trabalho de graduação de Análise e Desenvolvimento de Sistemas da FATEC Mogi Mirim.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>

<!-- CSS adicional para garantir que o footer não quebre -->
<style>
    .footer-section {
        overflow-x: hidden; /* Evita scroll horizontal */
    }
    
    .footer-top .lab-inner {
        display: flex;
        align-items: center;
        gap: 15px;
        flex-wrap: wrap;
    }
    
    .footer-top .lab-thumb img {
        max-width: 40px;
        height: auto;
        flex-shrink: 0;
    }
    
    .footer-top .lab-content {
        flex: 1;
        min-width: 0; /* Permite que o texto quebre corretamente */
    }
    
    .footer-top .lab-content span {
        word-wrap: break-word;
        overflow-wrap: break-word;
    }
    
    .footer-middle-item {
        max-width: 100%;
    }
    
    /* Responsividade adicional */
    @media (max-width: 768px) {
        .footer-top .lab-inner {
            text-align: center;
            flex-direction: column;
        }
        
        .fm-item-title img {
            max-width: 250px !important;
        }
    }
    
    @media (max-width: 480px) {
        .fm-item-title img {
            max-width: 200px !important;
        }
        
        .footer-top .lab-content span {
            font-size: 14px;
        }
    }
</style>
<!-- ================ footer Section end Here =============== -->