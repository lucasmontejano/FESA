@extends('layouts.app')

@section('title', 'Gerenciar Equipe: ' . $team->name)

@section('content')
<style>
    /* Base page styles */
    body.manage-team-page { /* Add this class to your <body> tag in layouts.app if this is a unique page style, or integrate globally */
        background-color: #12151c; /* Dark background */
        color: #e0e0e0; /* Light text */
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .manage-team-container {
        width: 90%;
        max-width: 900px; /* Adjusted max-width for content */
        margin: 40px auto;
        padding: 30px;
        background-color: rgba(28, 31, 38, 0.95); /* Slightly lighter dark card */
        border-radius: 12px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
    }

    .main-title {
        font-size: 28px;
        font-weight: bold;
        color: #fff;
        margin-bottom: 10px;
        padding-bottom: 10px;
        border-bottom: 2px solid #4da6ff; /* Blue accent */
    }

    .sub-title {
        font-size: 22px;
        font-weight: 600;
        color: #fff;
        margin-top: 30px;
        margin-bottom: 20px;
    }

    /* Alerts */
    .alert {
        padding: 15px;
        margin-bottom: 20px;
        border-radius: 6px;
        font-size: 16px;
    }
    .alert-success {
        background-color: rgba(76, 175, 80, 0.15); /* Greenish */
        color: #6ac06d;
        border: 1px solid #6ac06d;
    }
    .alert-danger {
        background-color: rgba(244, 67, 54, 0.15); /* Reddish */
        color: #f0786c;
        border: 1px solid #f0786c;
    }

    /* Member List */
    .member-list {
        list-style: none;
        padding: 0;
    }
    .member-item {
        background-color: #2a2e38; /* Darker item background */
        padding: 20px;
        margin-bottom: 15px;
        border-radius: 8px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-left: 4px solid #4da6ff; /* Blue accent */
        transition: all 0.3s ease;
    }
    .member-item:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 15px rgba(0,0,0,0.2);
    }

    .member-info {
        display: flex;
        align-items: center;
    }
    .member-avatar { /* Add this if you have avatars */
        width: 50px;
        height: 50px;
        border-radius: 50%;
        object-fit: cover;
        margin-right: 15px;
        border: 2px solid #4da6ff;
    }
    .member-name {
        font-size: 18px;
        font-weight: 600;
        color: #fff;
    }
    .member-role, .leader-tag {
        font-size: 14px;
        color: #aaa;
        margin-left: 8px;
        background-color: #353a47;
        padding: 3px 8px;
        border-radius: 4px;
    }
    .leader-tag {
        color: #4da6ff; /* Highlight leader */
        font-weight: bold;
    }

    .member-actions {
        display: flex;
        align-items: center;
        gap: 10px; /* Space between actions */
    }

    /* Styled Select Dropdown */
    .styled-select {
        background-color: #1c1f26; /* Dark background for select */
        color: #e0e0e0;
        padding: 8px 12px;
        border: 1px solid #353a47;
        border-radius: 6px;
        font-size: 14px;
        min-width: 100px; /* Adjust as needed */
    }
    .styled-select:focus {
        outline: none;
        border-color: #4da6ff;
        box-shadow: 0 0 0 2px rgba(77, 166, 255, 0.3);
    }

    /* Buttons */
    .btn {
        padding: 8px 15px;
        border-radius: 6px;
        text-decoration: none;
        font-weight: 600;
        font-size: 14px;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    .btn-primary {
        background-color: #4da6ff;
        color: white;
    }
    .btn-primary:hover {
        background-color: #3a8ad9;
        transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(77, 166, 255, 0.25);
    }
    .btn-secondary {
        background-color: #6c757d; /* Gray */
        color: white;
    }
    .btn-secondary:hover {
        background-color: #5a6268;
        transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(108, 117, 125, 0.25);
    }
    .btn-danger-sm {
        background-color: #dc3545; /* Red */
        color: white;
        padding: 6px 12px; /* Smaller padding */
        font-size: 13px;
    }
    .btn-danger-sm:hover {
        background-color: #c82333;
        transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(220, 53, 69, 0.25);
    }

    .actions-bar {
        margin-top: 30px;
        display: flex;
        gap: 15px; /* Space between buttons */
        justify-content: flex-start; /* Align buttons to the start */
    }

    /* Invite Link Section */
    .invite-link-section {
        margin-top: 20px;
        padding: 15px;
        background-color: #2a2e38;
        border-radius: 8px;
    }
    .invite-link-section label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        color: #fff;
    }
    .invite-link-input-wrapper {
        display: flex;
        gap: 10px;
    }
    .invite-link-input {
        flex-grow: 1;
        padding: 10px;
        background-color: #1c1f26;
        border: 1px solid #353a47;
        color: #e0e0e0;
        border-radius: 6px;
        font-size: 14px;
    }
    .invite-link-input:focus {
        outline: none;
        border-color: #4da6ff;
        box-shadow: 0 0 0 2px rgba(77, 166, 255, 0.3);
    }
    /* Add a class for copy button if you add one */
    .btn-copy {
        /* styles for copy button */
        padding: 10px 15px;
    }

</style>
<section class="pageheader-section" style="background-image: url(images/pageheader/bg.jpg);">
    <div class="manage-team-container">
        <h1 class="main-title">Gerenciar Equipe: {{ $team->name }}</h1>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <h2 class="sub-title">Membros da Equipe</h2>
        @if ($team->members->count() > 0)
            <ul class="member-list">
                @foreach ($team->members as $member)
                    <li class="member-item">
                        <div class="member-info">
                            <img src="{{ $member->profile_picture ? asset('images/profile_pictures/' . $member->profile_picture) : asset('images/profile_pictures/default-profile-picture.jpg') }}" alt="{{ $member->name }}" class="member-avatar">
                            <div>
                                <span class="member-name">{{ $member->name }}</span>
                                @if ($member->id === $team->leader_id)
                                    <span class="leader-tag">(Líder)</span>
                                @else
                                    <span class="member-role">({{ $member->pivot->role ?? 'Membro' }})</span>
                                @endif
                            </div>
                        </div>

                        <div class="member-actions">
                            @if (Auth::id() === $team->leader_id && $member->id !== $team->leader_id)
                                <form action="{{ route('teams.updateMemberRole', ['team' => $team->id, 'member' => $member->id]) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('PUT')
                                    <select name="role" onchange="this.form.submit()" class="styled-select">
                                        <option value="active" {{ $member->pivot->role === 'active' ? 'selected' : '' }}>Ativo</option>
                                        <option value="backup" {{ $member->pivot->role === 'backup' ? 'selected' : '' }}>Reserva</option>
                                    </select>
                                </form>

                                <form action="{{ route('teams.removeMember', ['team' => $team->id, 'member' => $member->name]) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger-sm" onclick="return confirm('Tem certeza que deseja remover {{ $member->name }} da equipe?')">Remover</button>
                                </form>

                            @endif
                        </div>
                    </li>
                @endforeach
            </ul>
        @else
            <p class="text-gray-400">Nenhum membro na equipe ainda.</p>
        @endif

        <div class="actions-bar flex justify-between items-center">
                <a href="{{ route('teams.show', $team->id) }}" class="btn btn-primary" style="background-color: #4a5568;">Voltar aos Detalhes</a>
            <form action="{{ route('teams.destroy', $team->id) }}" method="POST" onsubmit="return confirm('Você tem certeza que deseja deletar este time? Esta ação é irreversível.');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" style="background-color: #dc3545; color: white; padding: 10px 20px; border-radius: 5px; font-weight: 600; cursor: pointer;">
                    Deletar Time
                </button>
            </form>
        </div>

    </div>
</section>
    
<script>
    
</script>
@endsection