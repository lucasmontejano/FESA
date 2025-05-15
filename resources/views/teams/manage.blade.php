@extends('layouts.app')

@section('title', 'Meus Torneios')

@section('content')
    <!-- -----Banner----- -->
    <section class="banner-section">
        <div class="container">
            <h1>Manage Team: {{ $team->name }}</h1>

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

            <h2>Team Members</h2>
            <ul>
                @foreach ($team->members as $member)
                    <li>
                        {{ $member->name }} ({{ $member->pivot->role }})

                        @if ($member->id !== Auth::id()) {{-- Prevent leader from changing their own role or removing themselves --}}
                            <form action="{{ route('teams.updateMemberRole', ['team' => $team->id, 'member' => $member->id]) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('PUT')
                                <select name="role" onchange="this.form.submit()">
                                    <option value="active" {{ $member->pivot->role === 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="backup" {{ $member->pivot->role === 'backup' ? 'selected' : '' }}>Backup</option>
                                </select>
                            </form>

                            <form action="{{ route('teams.removeMember', ['team' => $team->id, 'member' => $member->id]) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to remove {{ $member->name }} from the team?')">Remove</button>
                            </form>
                        @else
                            (Leader)
                        @endif
                    </li>
                @endforeach
            </ul>

            <div class="mt-4">
                <a href="{{ route('teams.show', $team->id) }}" class="btn btn-primary">Back to Team Details</a>
                 <button onclick="generateInviteLink({{ $team->id }})" class="btn btn-secondary">
                    Generate Invite URL
                </button>
            </div>
            <div id="invite-link-container" style="display: none; margin-top: 10px;">
                <label for="invite-link">Invite Link:</label>
                <input type="text" id="invite-link" readonly style="width: 100%; padding: 5px;">
            </div>
        </div>
    </section>
                   
    <script>
        function generateInviteLink(teamId) {
            fetch(`/teams/${teamId}/invite`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error("Request failed");
                }
                return response.json();
            })
            .then(data => {
                const container = document.getElementById('invite-link-container');
                const input = document.getElementById('invite-link');
                input.value = data.url;
                container.style.display = 'block';
            })
            .catch(error => {
                alert("Failed to generate invite. You may not have permission.");
                console.error(error);
            });
        }
    </script>

    <!-- -----Banner----- -->
@endsection