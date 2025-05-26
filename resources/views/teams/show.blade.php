@extends('layouts.app')

@section('title', $team->name . ' - Team Page')

@section('content')
<style>
    body {
        background-color: #12151c;
        margin: 0;
        padding: 0;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        min-height: 100vh;
    }

    .pageheader-section {
        min-height: 60vh;
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 40px 20px;
    }

    .profile-wrapper {
        width: 90%;
        max-width: 1200px;
        margin: 0 auto;
        padding: 30px;
        background-color: rgba(28, 31, 38, 0.95);
        border-radius: 12px;
        color: #fff;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
    }

    .profile-card {
        display: flex;
        align-items: center;
        gap: 40px;
        margin-bottom: 40px;
        padding-bottom: 30px;
        border-bottom: 1px solid #2a2e38;
    }

    .profile-avatar {
        width: 180px;
        height: 180px;
        border-radius: 12px;
        object-fit: cover;
        border: 3px solid #4da6ff;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
    }

    .profile-info {
        flex: 1;
    }

    .profile-name {
        font-size: 36px;
        font-weight: bold;
        margin-bottom: 10px;
        color: #fff;
    }

    .profile-description {
        font-size: 16px;
        color: #ddd;
    }

    .btn-primary {
        background-color: #4da6ff;
        color: white;
        border: none;
        padding: 12px 24px;
        border-radius: 6px;
        font-weight: 600;
        text-decoration: none;
        display: inline-block;
        margin-right: 10px;
        margin-top: 10px;
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        background-color: #3a8ad9;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(77, 166, 255, 0.3);
    }

    .section-title {
        font-size: 24px;
        margin-bottom: 20px;
        color: #fff;
        border-bottom: 2px solid #4da6ff;
        padding-bottom: 10px;
        display: inline-block;
    }

    .roster-container {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        margin-top: 20px;
    }

    .roster-member {
        display: flex;
        flex-direction: column;
        align-items: center; /* centraliza horizontalmente */
        justify-content: center; /* centraliza verticalmente */
        background-color: #2a2e38;
        padding: 20px;
        border-radius: 10px;
        text-align: center;
        width: 120px;
        color: #ccc;
        transition: all 0.3s ease;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    .roster-member:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
    }

    .roster-member img {
        width: 64px;
        height: 64px;
        border-radius: 50%;
        object-fit: cover;
        margin-bottom: 8px;
        border: 2px solid #4da6ff;
    }

    .roster-member-name {
        font-size: 14px;
        font-weight: 500;
        color: #fff;
    }

    .roster-member-role {
        font-size: 12px;
        color: #aaa;
    }

    @media (max-width: 768px) {
        .profile-card {
            flex-direction: column;
            text-align: center;
            gap: 20px;
        }

        .profile-info {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .roster-container {
            justify-content: center;
        }
    }

.roster-container {
        display: flex;
        flex-wrap: nowrap;
        overflow-x: auto;
        gap: 20px;
        padding-bottom: 20px;
        -webkit-overflow-scrolling: touch;
    }

    .roster-member {
        flex: 0 0 auto;
        cursor: grab;
        user-select: none;
    }

    .roster-member.leader {
        cursor: default;
        background-color: rgba(77, 166, 255, 0.1);
        border-left: 3px solid #4da6ff;
    }

    .roster-member.dragging {
        opacity: 0.5;
        transform: scale(0.95);
    }

    .roster-member.active {
        border-left: 3px solid #28a745;
    }

    .roster-member.backup {
        border-left: 3px solid #6c757d;
    }

    .save-roster-btn {
        display: none;
        margin-top: 20px;
        background: linear-gradient(135deg, #4da6ff, #3385d6);
        color: white;
        border: none;
        padding: 12px 24px;
        border-radius: 6px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .save-roster-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(77, 166, 255, 0.3);
    }

    .save-roster-btn.visible {
        display: inline-block;
    }

    /* Hide scrollbar but keep functionality */
    .roster-container::-webkit-scrollbar {
        display: none;
    }
</style>

<div style="padding-top: 100px;">
    <section class="pageheader-section" style="background-image: url('{{ asset('images/pageheader/bg.jpg') }}');">
        <div class="profile-wrapper">
            {{-- Team Card --}}
            <div class="profile-card">
                <img class="profile-avatar" src="{{ $team->picture ? asset('images/team_pictures/' . $team->picture) : asset('images/team_pictures/default-team-picture.jpg') }}" alt="{{ $team->name }}">
                <div class="profile-info">
                    <div class="profile-name">{{ $team->name }}</div>
                    <div class="profile-description">Líder: {{ $team->leader->name }}</div>
                    @auth
                        @if (Auth::id() === $team->leader_id)
                            <a href="{{ route('teams.manage', $team->id) }}" class="btn-primary">Gerenciar Time</a>
                            @can('update', $team)
                            <button onclick="generateInviteLink('{{ $team->id }}')" class="btn-primary">
                                Gerar convite
                            </button>

                            <div id="invite-link-container-{{ $team->id }}" style="display: none; margin-top: 10px;">
                                <div class="input-group">
                                    <input type="text" id="invite-link-{{ $team->id }}" class="form-control" readonly>
                                    <button class="btn btn-outline-secondary" onclick="copyInviteLink({{ $team->id }})">
                                        Copiar
                                    </button>
                                </div>
                                <small class="text-muted" id="invite-expires-{{ $team->id }}"></small>
                                <small class="text-muted d-block">This link can be used by multiple players</small>
                            </div>
                            @endcan
                        @endif
                    @endauth
                </div>
            </div>

            {{-- Roster --}}
            <div>
                <h3 class="section-title">Integrantes</h3>
                <div class="roster-container" id="sortable-roster">
                    <!-- Leader (fixed first position) -->
                    <div class="roster-member leader" data-user-id="{{ $team->leader->id }}">
                        <img src="{{ $team->leader->profile_picture ? asset('images/profile_pictures/' . $team->leader->profile_picture) : asset('images/profile_pictures/default-profile-picture.jpg') }}" alt="{{ $team->leader->name }}">
                        <div class="roster-member-name">
                            <a href="{{ route('users.show', $team->leader->name) }}" class="roster-member-name">
                                {{ $team->leader->name }}
                            </a>
                        </div>
                        <div class="roster-member-role">Líder</div>
                    </div>

                    <!-- Other members (sortable) -->
                    @foreach ($team->members->where('id', '!=', $team->leader_id) as $member)
                        <div class="roster-member @if($loop->index < 4) active @else backup @endif" 
                             data-user-id="{{ $member->id }}">
                            <img src="{{ $member->profile_picture ? asset('images/profile_pictures/' . $member->profile_picture) : asset('images/profile_pictures/default-profile-picture.jpg') }}" alt="{{ $member->name }}">
                            <div class="roster-member-name">
                                <a href="{{ route('users.show', $member->name) }}" class="roster-member-name">
                                    {{ $member->name }}
                                </a>
                            </div>
                            <div class="roster-member-role">
                                {{ $member->pivot->role === 'active' ? 'Titular' : 'Reserva' }}
                            </div>
                        </div>
                    @endforeach
                </div>

                @can('update', $team)
                <button id="save-roster-btn" class="save-roster-btn">
                    <i class="icofont-save"></i> Salvar Formação
                </button>
                @endcan
            </div>
        </div>
    </section>
</div>

<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.14.0/Sortable.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const rosterContainer = document.getElementById('sortable-roster');
    const saveBtn = document.getElementById('save-roster-btn');
    
    // Initialize SortableJS on roster container
    new Sortable(rosterContainer, {
        animation: 150,
        draggable: '.roster-member:not(.leader)', // Only non-leaders are draggable
        ghostClass: 'dragging',
        onStart: function() {
            saveBtn.classList.add('visible');
        },
        onUpdate: function() {
            updateMemberRoles();
        }
    });

    // Update role classes based on position
    function updateMemberRoles() {
        const members = document.querySelectorAll('#sortable-roster .roster-member:not(.leader)');
        
        members.forEach((member, index) => {
            member.classList.remove('active', 'backup');
            if (index < 4) {
                member.classList.add('active');
            } else {
                member.classList.add('backup');
            }
        });
    }

    // Save roster positions
    saveBtn.addEventListener('click', function() {
        const memberIds = Array.from(document.querySelectorAll('#sortable-roster .roster-member:not(.leader)'))
            .map(member => member.dataset.userId);
        
        fetch('{{ route('teams.updatePositions', $team->id) }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                member_ids: memberIds
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Formação salva com sucesso!');
                location.reload();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Erro ao salvar formação');
        });
    });
});

// Your existing invite link functions
    function generateInviteLink(teamId) {
        // Forma mais robusta de obter o token CSRF, caso este script esteja em um arquivo .js separado
        // Certifique-se de ter <meta name="csrf-token" content="{{ csrf_token() }}"> no <head> do seu HTML.
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        fetch(`/teams/${teamId}/invite`, { // Certifique-se que esta rota POST exista
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            }
        })
        .then(response => {
            if (!response.ok) {
                return response.json().then(errData => {
                    throw new Error(errData.message || "Falha ao gerar o link. Código: " + response.status);
                }).catch(() => {
                    throw new Error("Falha ao gerar o link. Código: " + response.status);
                });
            }
            return response.json();
        })
        .then(data => {
            if (data.url) {
                const container = document.getElementById(`invite-link-container-${teamId}`);
                const inputField = document.getElementById(`invite-link-${teamId}`);
                const expiryInfoElement = document.getElementById(`invite-expires-${teamId}`);
                
                // Encontra o elemento <small> genérico para poder escondê-lo se necessário
                const genericMultipleUseTextElement = container.querySelector('small.text-muted.d-block');


                if (inputField) {
                    inputField.value = data.url;
                }

                let displayText = '';
                if (data.max_uses && data.uses_left !== undefined) {
                    displayText = `Válido para ${data.uses_left} ${data.uses_left === 1 ? 'uso' : 'usos'}`;
                }

                if (data.expires) { // data.expires vem do diffForHumans()
                    if (displayText) {
                        displayText += `, expira ${data.expires}.`;
                    } else {
                        displayText = `Expira ${data.expires}.`;
                    }
                } else if (displayText) {
                    displayText += '.'; // Adiciona um ponto final se apenas o texto de usos estiver presente
                }


                if (expiryInfoElement) {
                    expiryInfoElement.textContent = displayText || 'Link gerado.'; // Atualiza o conteúdo do <small>
                    expiryInfoElement.style.display = 'inline'; // Garante que esteja visível (pode ser 'block' se preferir nova linha)
                }
                
                // Se exibimos informações detalhadas, escondemos a mensagem genérica
                if (genericMultipleUseTextElement && displayText) {
                    genericMultipleUseTextElement.style.display = 'none';
                } else if (genericMultipleUseTextElement) {
                     genericMultipleUseTextElement.style.display = 'block'; // Ou 'inline'
                }


                if (container) {
                    container.style.display = 'block';
                }

            } else {
                alert(data.message || "Erro ao obter URL do link.");
            }
        })
        .catch(error => {
            alert(error.message || "Falha ao gerar o link de convite. Verifique se você tem permissão.");
            console.error('Error generating invite link:', error);
        });
    }

    function copyInviteLink(teamId) {
        const inputField = document.getElementById(`invite-link-${teamId}`);
        if (!inputField) {
            console.error(`Campo de input invite-link-${teamId} não encontrado.`);
            return;
        }

        inputField.select(); // Seleciona o texto no campo de input
        inputField.setSelectionRange(0, 99999); // Para compatibilidade com dispositivos móveis

        try {
            var successful = document.execCommand('copy'); // Tenta copiar o texto selecionado
            var msg = successful ? 'Link copiado para a área de transferência!' : 'Falha ao copiar o link.';
            alert(msg);
        } catch (err) {
            alert('Oops, não foi possível copiar. Por favor, copie manualmente.');
            console.error('Erro ao copiar o texto: ', err);
        }
    }
</script>
@endsection