<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Models\TeamInvite;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;

class TeamController extends Controller
{   
    use AuthorizesRequests;
    /**
     * Show the form for creating a new team.
     */
    public function create()
    {
        return view('teams.create');
    }

    /**
     * Store a newly created team in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $team = new Team();
        $team->name = $request->name;

        if ($request->hasFile('picture')) {
            $imageName = time().'.'.$request->picture->extension();
            $request->picture->move(public_path('images/team_pictures'), $imageName);
            $team->picture = $imageName;
        }

        $team->leader_id = Auth::id();
        $team->save();

        // Add the leader as an active member of the team
        $team->members()->attach(Auth::id(), ['role' => 'active']);

        return redirect()->route('teams.show', $team->id)->with('success', 'Time criado com sucesso!');
    }

    /**
     * Display the specified team.
     */
    public function show(Team $team)
    {
        $team->load('leader', 'members'); // Eager load leader and members
        return view('teams.show', compact('team'));
    }

    /**
     * Handle a user joining a team via invitation URL.
     */
    public function join(Request $request)
    {
        $token = $request->token;

        // In a real application, you would look up the team based on the token
        // and validate the token (e.g., check for expiration).
        // For this example, we'll assume you have a way to get the team from the token.

        // Assuming you have a way to get the team from the token:
        // $team = Team::where('invite_token', $token)->first();

        // For demonstration purposes, let's assume the token is the team ID for now
        $team = Team::find($token);


        if (!$team) {
            abort(404); // Or redirect to an error page
        }

        $user = Auth::user();

        // Check if the user is already on this team
        if ($team->members->contains($user)) {
            return redirect()->route('teams.show', $team->id)->with('info', 'You are already a member of this team.');
        }

        // Add the user to the team as an active member
        $team->members()->attach($user->id, ['role' => 'active']);

        return redirect()->route('teams.show', $team->id)->with('success', 'Você juntou-se a uma equipe com sucesso!');
    }

    /**
     * Show the form for managing team members and roles.
     */
    public function manage(Team $team)
    {
        // Ensure the authenticated user is the team leader
        if (Auth::id() !== $team->leader_id) {
            abort(403);
        }

        $team->load('members'); // Eager load members
        return view('teams.manage', compact('team'));
    }

    /**
     * Update the role of a team member.
     */
    public function updateMemberRole(Request $request, Team $team, User $member)
    {
        // Ensure the authenticated user is the team leader
        if (Auth::id() !== $team->leader_id) {
            abort(403);
        }

        $request->validate([
            'role' => 'required|in:active,backup',
        ]);

        $team->members()->updateExistingPivot($member->id, ['role' => $request->role]);

        return redirect()->route('teams.manage', $team->id)->with('success', 'Membros atualizados com sucesso!');
    }

    /**
     * Remove a member from the team.
     */
    public function removeMember(Team $team, User $member)
    {
        $this->authorize('removeMember', [$team, $member]); // $member aqui é $memberToRemove

        // 2. Prevenir que o líder se remova por este método
        if ($member->id === $team->leader_id) {
            return back()->with('error', 'O líder não pode ser removido desta forma. Considere transferir a liderança ou usar outra opção para gerenciar a equipe.');
        }

        // 3. Verificar se o usuário é realmente membro da equipe (redundante se o frontend só mostra membros)
        if (!$team->members()->where('user_id', $member->id)->exists()) {
            return back()->with('error', 'Este usuário não é membro desta equipe ou já foi removido.');
        }

        // 4. Remover (desanexar) o membro da equipe
        try {
            // A relação 'members' no seu modelo Team é usada aqui
            $team->members()->detach($member->id);

            // Você pode querer adicionar lógica aqui para, por exemplo,
            // promover um membro reserva para ativo se um ativo for removido,
            // ou limpar convites pendentes para este usuário nesta equipe, etc.
            // Por enquanto, vamos manter simples.

            return back()->with('success', $member->name . ' foi removido(a) da equipe com sucesso.');

        } catch (\Exception $e) {
            Log::error("Erro ao remover membro ID {$member->id} da equipe ID {$team->id}: " . $e->getMessage());
            return back()->with('error', 'Ocorreu um erro ao tentar remover o membro. Por favor, tente novamente.');
        }
    }

    public function generateInviteUrl(Team $team)
    {
        $this->authorize('update', $team); // Good: Authorize first
    
        // Check if team is full before generating a new link
        if (!$team->canAddMember()) {
            return response()->json(['message' => 'A equipe está cheia e não pode aceitar novos membros no momento.'], 400);
        }

        $invite = TeamInvite::updateOrCreate( // Assuming TeamInvite model exists
            [
                'team_id' => $team->id,
                'sender_id' => auth()->id()
            ],
            [
                'token' => Str::random(32), // Generate a new token
                'expires_at' => now()->addDays(7), // Or now()->addHours(24) if you prefer 24hr expiry
                'max_uses' => 6,  // <<< Set max uses to 6
                'uses' => 0       // <<< Reset current uses to 0
            ]
        );

        return response()->json([
            'url' => route('teams.acceptInvite', $invite->token),
            'expires' => $invite->expires_at->diffForHumans(), // "in 7 days", "in 24 hours"
            'max_uses' => $invite->max_uses,
            'uses_left' => $invite->max_uses - $invite->uses // Will be 6 for a new/refreshed link
        ]);
    }

    public function acceptInvite($token)
    {
        $invite = TeamInvite::where('token', $token)
                                    ->where('expires_at', '>', now())
                                    ->with('team')
                                    ->first();

        if (!$invite) {
            return redirect()->route('teams.index')->with('error', 'Link de convite inválido.');
        }

        if ($invite->expires_at->isPast()) {
            return redirect()->route('teams.index')->with('error', 'Este link de convite expirou.');
        }

        if (isset($invite->max_uses) && $invite->uses >= $invite->max_uses) {
            return redirect()->route('teams.index')->with('error', 'Este link de convite já atingiu o número máximo de usos.');
        }

        $role = $invite->team->canAddActiveMember() ? 'active' : 'backup';
        $invite->team->members()->attach(auth()->id(), [
            'role' => $role,
            'joined_at' => now()
        ]);

        //$invite->increment('uses');
        $invite->uses = $invite->uses + 1;
        $invite->timestamps = false; 
        $invite->save(['touch' => false]); 
        $invite->timestamps = true;

        $invite->refresh();

        if (isset($invite->max_uses) && $invite->uses >= $invite->max_uses) {
            $invite->delete(); // Comente temporariamente para inspeção no BD
        }

        return redirect()->route('teams.show', $invite->team_id)
            ->with('success', "Você entrou na equipe '{$invite->team->name}' como {$role}!");
    }


    public function showInvite($token)
    {
        $invite = TeamInvite::where('token', $token)
                    ->where('expires_at', '>', now())
                    ->firstOrFail();

        return view('teams.invite', compact('invite'));
    }

    public function updatePositions(Request $request, Team $team)
    {
        $this->authorize('update', $team);
        
        $memberIds = $request->input('member_ids');
        
        // Update all members to backup first
        $team->members()->updateExistingPivot($memberIds, ['role' => 'backup']);
        
        // Update first 4 members to active
        $activeMembers = array_slice($memberIds, 0, 4);
        $team->members()->updateExistingPivot($activeMembers, ['role' => 'active']);
        
        return response()->json(['success' => true]);
    }

    public function destroy(Team $team)
    {
        // 1. Autorização: Garante que apenas o líder do time pode deletá-lo.
        // Se você usa Policies, pode usar: $this->authorize('delete', $team);
        if (Auth::id() !== $team->leader_id) {
            abort(403, 'AÇÃO NÃO AUTORIZADA.');
        }

        try {
            // 2. Desanexar Relações (Boa prática para evitar erros de constraint)
            // Remove todas as inscrições do time em torneios.
            $team->tournaments()->detach();
            
            // Remove todos os membros do time da tabela pivot 'team_members'.
            $team->members()->detach();

            // Deleta todos os convites pendentes para este time.
            $team->invites()->delete();

            // 3. Deletar a Imagem do Time (se existir)
            if ($team->picture) {
                $imagePath = public_path('images/team_pictures/' . $team->picture);
                if (File::exists($imagePath)) {
                    File::delete($imagePath);
                }
            }

            // 4. Deletar o Time
            $team->delete();

            // 5. Redirecionar para o dashboard ou perfil com uma mensagem de sucesso.
            return redirect()->route('dashboard')->with('success', 'O time foi deletado com sucesso.');

        } catch (\Exception $e) {
            // Em caso de qualquer erro inesperado, redireciona com uma mensagem de erro.
            Log::error("Erro ao deletar o time ID {$team->id}: " . $e->getMessage());
            return back()->with('error', 'Ocorreu um erro ao tentar deletar o time. Por favor, tente novamente.');
        }
    }   

    public function leave(Team $team)
    {
        $user = Auth::user();

        // 1. Garante que o líder não pode usar esta função para sair do próprio time
        if ($user->id === $team->leader_id) {
            return back()->with('error', 'O líder não pode abandonar o time. Transfira a liderança ou delete o time na área de gerenciamento.');
        }

        // 2. Garante que o usuário é de fato um membro antes de tentar sair
        if (!$team->members()->where('user_id', $user->id)->exists()) {
            return back()->with('info', 'Você não é membro deste time.');
        }

        try {
            // 3. Remove a associação do usuário com o time na tabela pivot
            $team->members()->detach($user->id);

            // 4. Redireciona o usuário para seu perfil com uma mensagem de sucesso
            return redirect()->route('users.show', ['user' => $user->name])->with('success', "Você saiu do time '{$team->name}'.");

        } catch (\Exception $e) {
            // Log do erro e mensagem genérica para o usuário
            Log::error("Erro ao sair do time ID {$team->id} para o usuário ID {$user->id}: " . $e->getMessage());
            return back()->with('error', 'Ocorreu um erro ao tentar sair do time. Por favor, tente novamente.');
        }
    }

    public function updatePicture(Request $request, Team $team)
    {
        // 1. Autorização: Garante que apenas o líder do time pode mudar a foto.
        if (Auth::id() !== $team->leader_id) {
            abort(403, 'Ação não autorizada.');
        }

        // 2. Validação: Garante que o arquivo enviado é uma imagem válida.
        $request->validate([
            'picture' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // max 2MB
        ]);

        // 3. Deleta a foto antiga (se existir)
        if ($team->picture) {
            $oldPicturePath = public_path('images/team_pictures/' . $team->picture);
            if (File::exists($oldPicturePath)) {
                File::delete($oldPicturePath);
            }
        }

        // 4. Salva a nova foto
        $imageFile = $request->file('picture');
        $imageName = time() . '.' . $imageFile->getClientOriginalExtension();
        $imageFile->move(public_path('images/team_pictures'), $imageName);

        // 5. Atualiza o registro no banco de dados
        $team->picture = $imageName;
        $team->save();

        // 6. Redireciona de volta com uma mensagem de sucesso
        return back()->with('success', 'Foto do time atualizada com sucesso!');
    }
}
