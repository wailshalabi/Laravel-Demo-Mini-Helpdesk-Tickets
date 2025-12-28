<?php

namespace App\Policies;

use App\Models\Ticket;
use App\Models\User;

class TicketPolicy
{
    public function viewAny(User $user): bool
    {
        return (bool) $user;
    }

    public function view(User $user, Ticket $ticket): bool
    {
        return $user->isAdmin()
            || $ticket->created_by === $user->id
            || $ticket->assigned_to === $user->id;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Ticket $ticket): bool
    {
        return $user->isAdmin()
            || $ticket->created_by === $user->id
            || ($user->isAgent() && $ticket->assigned_to === $user->id);
    }

    public function delete(User $user, Ticket $ticket): bool
    {
        return $user->isAdmin();
    }

    public function assign(User $user): bool
    {
        return $user->isAdmin();
    }
}
