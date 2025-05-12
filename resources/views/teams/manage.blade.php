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
                 <a href="{{ route('teams.generateInviteUrl', $team->id) }}" class="btn btn-secondary">Generate Invite URL</a>
            </div>
        </div>
    </section>
                   
    <!-- -----Banner----- -->
@endsection