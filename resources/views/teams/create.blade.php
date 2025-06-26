@extends('layouts.app')

@section('title', 'Criar Novo Time')

@section('content')
    <section class="pageheader-section">
        <!-- Efeitos de fundo decorativos -->
        <div style="position: absolute; top: -50%; left: -50%; width: 200%; height: 200%; background: url('data:image/svg+xml,<svg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 100 100\"><defs><pattern id=\"grain\" width=\"100\" height=\"100\" patternUnits=\"userSpaceOnUse\"><circle cx=\"50\" cy=\"50\" r=\"1\" fill=\"%23ffffff\" opacity=\"0.1\"/><circle cx=\"25\" cy=\"25\" r=\"0.5\" fill=\"%23ffffff\" opacity=\"0.05\"/><circle cx=\"75\" cy=\"75\" r=\"0.8\" fill=\"%23ffffff\" opacity=\"0.08\"/></pattern></defs><rect width=\"100\" height=\"100\" fill=\"url(%23grain)\"/></svg>'); opacity: 0.3; animation: float 20s ease-in-out infinite;"></div>
        
        <section class="banner" style="position: relative; z-index: 2; padding: 80px 0;">
            <div class="container">
                <!-- Título com design moderno -->
                <div style="text-align: center; margin-bottom: 50px;">
                    <div style="display: inline-block; padding: 12px 24px; background: rgba(255,255,255,0.15); border-radius: 50px; backdrop-filter: blur(10px); margin-bottom: 20px;">
                        <span style="color: white; font-size: 14px; font-weight: 600; text-transform: uppercase; letter-spacing: 2px;">⚡ Novo Time</span>
                    </div>
                    <p style="color: rgba(255,255,255,0.8); font-size: 1.2rem; margin-top: 10px; font-weight: 300;">Crie seu time e comece sua jornada competitiva</p>
                </div>

                <!-- Formulário com design glassmorphism -->
                <div style="max-width: 600px; margin: 0 auto;">
                    <div style="background: rgba(255,255,255,0.1); backdrop-filter: blur(20px); border-radius: 24px; padding: 40px; border: 1px solid rgba(255,255,255,0.2); box-shadow: 0 20px 40px rgba(0,0,0,0.1);">
                        <form action="{{ route('teams.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            
                            <!-- Campo Nome do Time -->
                            <div style="margin-bottom: 32px; position: relative;">
                                <label for="name" style="color: white; font-weight: 600; font-size: 16px; margin-bottom: 12px; display: block; text-shadow: 0 2px 4px rgba(0,0,0,0.3);">
                                    🏆 Nome do Time
                                    <span style="color: rgba(255,255,255,0.7); font-size: 14px; font-weight: 400;">(máximo 32 caracteres)</span>
                                </label>
                                <div style="position: relative;">
                                    <input type="text" 
                                           class="form-control" 
                                           id="name" 
                                           name="name"
                                           maxlength="32" 
                                           required
                                           oninput="this.value = this.value.slice(0, 32); updateCharCount(this)"
                                           style="background: rgba(255,255,255,0.9); 
                                                  border: 2px solid rgba(255,255,255,0.3); 
                                                  border-radius: 16px; 
                                                  padding: 16px 20px; 
                                                  font-size: 16px; 
                                                  font-weight: 500;
                                                  color: #333;
                                                  box-shadow: inset 0 2px 10px rgba(0,0,0,0.1);
                                                  transition: all 0.3s ease;
                                                  width: 100%;"
                                           placeholder="Digite o nome do seu time..."
                                           onfocus="this.style.borderColor='rgba(255,255,255,0.8)'; this.style.boxShadow='inset 0 2px 10px rgba(0,0,0,0.1), 0 0 0 4px rgba(255,255,255,0.2)'"
                                           onblur="this.style.borderColor='rgba(255,255,255,0.3)'; this.style.boxShadow='inset 0 2px 10px rgba(0,0,0,0.1)'">
                                    <div id="charCount" style="position: absolute; right: 16px; top: 16px; color: #666; font-size: 12px; font-weight: 600;">0/32</div>
                                </div>
                            </div>

                            <!-- Campo Upload de Imagem -->
                            <div style="margin-bottom: 40px; position: relative;">
                                <label for="picture" style="color: white; font-weight: 600; font-size: 16px; margin-bottom: 12px; display: block; text-shadow: 0 2px 4px rgba(0,0,0,0.3);">
                                    📸 Logo do Time
                                    <span style="color: rgba(255,255,255,0.7); font-size: 14px; font-weight: 400;">(Opcional - JPG/PNG, máx 2MB)</span>
                                </label>
                                
                                <!-- Área de upload customizada -->
                                <div style="position: relative;">
                                    <div id="uploadArea" style="background: rgba(255,255,255,0.9); 
                                                                 border: 2px dashed rgba(102, 126, 234, 0.4); 
                                                                 border-radius: 16px; 
                                                                 padding: 40px 20px; 
                                                                 text-align: center;
                                                                 cursor: pointer;
                                                                 transition: all 0.3s ease;"
                                         onclick="document.getElementById('picture').click()"
                                         onmouseover="this.style.borderColor='rgba(102, 126, 234, 0.8)'; this.style.background='rgba(255,255,255,0.95)'"
                                         onmouseout="this.style.borderColor='rgba(102, 126, 234, 0.4)'; this.style.background='rgba(255,255,255,0.9)'">
                                        
                                        <div id="uploadContent">
                                            <div style="font-size: 48px; margin-bottom: 16px; color: #667eea;">📁</div>
                                            <p style="color: #333; font-weight: 600; margin: 0; font-size: 16px;">Clique para selecionar uma imagem</p>
                                            <p style="color: #666; margin: 8px 0 0 0; font-size: 14px;">ou arraste e solte aqui</p>
                                        </div>
                                        
                                        <div id="uploadPreview" style="display: none;">
                                            <img id="previewImage" style="max-width: 120px; max-height: 120px; border-radius: 12px; margin-bottom: 12px;">
                                            <p id="fileName" style="color: #333; font-weight: 600; margin: 0; font-size: 14px;"></p>
                                            <p style="color: #667eea; font-size: 12px; margin: 4px 0 0 0;">✓ Imagem carregada com sucesso</p>
                                        </div>
                                    </div>
                                    
                                    <input type="file" 
                                           id="picture" 
                                           name="picture"
                                           accept="image/jpeg, image/png, image/jpg"
                                           onchange="validateImage(this); showPreview(this)"
                                           style="display: none;">
                                </div>
                            </div>

                            <!-- Botão Submit -->
                            <div style="text-align: center;">
                                <button type="submit" 
                                        style="background: linear-gradient(45deg, #667eea, #764ba2); 
                                               color: white; 
                                               border: none; 
                                               padding: 18px 40px; 
                                               border-radius: 50px; 
                                               font-size: 18px; 
                                               font-weight: 700; 
                                               cursor: pointer; 
                                               box-shadow: 0 10px 30px rgba(102, 126, 234, 0.4);
                                               transition: all 0.3s ease;
                                               text-transform: uppercase;
                                               letter-spacing: 1px;
                                               position: relative;
                                               overflow: hidden;"
                                        onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 15px 40px rgba(102, 126, 234, 0.6)'"
                                        onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 10px 30px rgba(102, 126, 234, 0.4)'"
                                        onmousedown="this.style.transform='translateY(1px)'"
                                        onmouseup="this.style.transform='translateY(-2px)'">
                                    🚀 Criar Time
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </section>

    <style>
        @keyframes float {
            0%, 100% { transform: translateX(0) translateY(0) rotate(0deg); }
            33% { transform: translateX(20px) translateY(-20px) rotate(120deg); }
            66% { transform: translateX(-20px) translateY(20px) rotate(240deg); }
        }
        
        /* Efeito de focus melhorado */
        input[type="text"]:focus {
            outline: none !important;
        }
        
        /* Animação para o botão */
        button[type="submit"]::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
            transition: left 0.5s;
        }
        
        button[type="submit"]:hover::before {
            left: 100%;
        }
    </style>

    <script>
        function validateImage(input) {
            if (input.files && input.files[0]) {
                const file = input.files[0];
                const validTypes = ['image/jpeg', 'image/png', 'image/jpg'];
                const maxSize = 2 * 1024 * 1024; // 2MB in bytes
                
                if (!validTypes.includes(file.type)) {
                    alert('Por favor, envie apenas imagens JPG ou PNG.');
                    input.value = '';
                    resetUploadArea();
                    return false;
                }
                
                if (file.size > maxSize) {
                    alert('O tamanho da imagem deve ser menor que 2MB.');
                    input.value = '';
                    resetUploadArea();
                    return false;
                }
            }
            return true;
        }
        
        function showPreview(input) {
            if (input.files && input.files[0]) {
                const file = input.files[0];
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    document.getElementById('uploadContent').style.display = 'none';
                    document.getElementById('uploadPreview').style.display = 'block';
                    document.getElementById('previewImage').src = e.target.result;
                    document.getElementById('fileName').textContent = file.name;
                    document.getElementById('uploadArea').style.borderColor = '#28a745';
                    document.getElementById('uploadArea').style.background = 'rgba(40, 167, 69, 0.1)';
                };
                
                reader.readAsDataURL(file);
            }
        }
        
        function resetUploadArea() {
            document.getElementById('uploadContent').style.display = 'block';
            document.getElementById('uploadPreview').style.display = 'none';
            document.getElementById('uploadArea').style.borderColor = 'rgba(102, 126, 234, 0.4)';
            document.getElementById('uploadArea').style.background = 'rgba(255,255,255,0.9)';
        }
        
        function updateCharCount(input) {
            const count = input.value.length;
            const counter = document.getElementById('charCount');
            counter.textContent = count + '/32';
            
            if (count > 28) {
                counter.style.color = '#e74c3c';
            } else if (count > 20) {
                counter.style.color = '#f39c12';
            } else {
                counter.style.color = '#666';
            }
        }
        
        // Adiciona funcionalidade de drag and drop
        const uploadArea = document.getElementById('uploadArea');
        
        uploadArea.addEventListener('dragover', function(e) {
            e.preventDefault();
            this.style.borderColor = '#667eea';
            this.style.background = 'rgba(102, 126, 234, 0.1)';
        });
        
        uploadArea.addEventListener('dragleave', function(e) {
            e.preventDefault();
            this.style.borderColor = 'rgba(102, 126, 234, 0.4)';
            this.style.background = 'rgba(255,255,255,0.9)';
        });
        
        uploadArea.addEventListener('drop', function(e) {
            e.preventDefault();
            const files = e.dataTransfer.files;
            if (files.length > 0) {
                document.getElementById('picture').files = files;
                validateImage(document.getElementById('picture'));
                showPreview(document.getElementById('picture'));
            }
            this.style.borderColor = 'rgba(102, 126, 234, 0.4)';
            this.style.background = 'rgba(255,255,255,0.9)';
        });
    </script>
@endsection