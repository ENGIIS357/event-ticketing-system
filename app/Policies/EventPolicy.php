<?php

namespace App\Policies;

use App\Models\Event;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class EventPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Event $event): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return $user->isOrganizer() || $user->isAdmin();
    }

    public function update(User $user, Event $event): bool
    {
        return $user->id === $event->user_id || $user->isAdmin();
    }

    public function delete(User $user, Event $event): bool
    {
        return $user->id === $event->user_id || $user->isAdmin();
    }

    public function manage(User $user, Event $event): bool
    {
        return $user->id === $event->user_id;
    }

    public function viewStatistics(User $user, Event $event): bool
    {
        return $user->id === $event->user_id || $user->isAdmin();
    }
}