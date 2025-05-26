<?php

namespace App\Policies;

use App\Models\Team;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TeamPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Team $team): bool
    {
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Team $team)
    {
        return $team->leader_id === $user->id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Team $team): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Team $team): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Team $team): bool
    {
        return false;
    }

    public function addMember(User $user, Team $team)
    {
        return $team->canAddMember();
    }

    /**
     * Determina se o usuário autenticado pode remover um membro específico da equipe.
     *
     * @param  \App\Models\User  $user O usuário autenticado (quem está tentando a ação)
     * @param  \App\Models\Team  $team A equipe da qual o membro será removido
     * @param  \App\Models\User  $memberToRemove O membro que se deseja remover
     * @return bool
     */
    public function removeMember(User $user, Team $team, User $memberToRemove): bool
    {
        return $user->id === $team->leader_id && $memberToRemove->id !== $team->leader_id;
    }
}
