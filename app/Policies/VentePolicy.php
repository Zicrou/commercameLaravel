<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Vente;
use Illuminate\Auth\Access\Response;

class VentePolicy
{
    public function modify(User $user, Vente $vente): Response
    {
        return $user->id === $vente->user_id
            ? Response::allow()
            : Response::deny('You do not own this vente.');
    }
}