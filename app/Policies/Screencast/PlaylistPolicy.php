<?php

namespace App\Policies\Screencast;

use App\Models\Screencast\Playlist;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PlaylistPolicy
{
    use HandlesAuthorization;

    public function optionAccessRights(User $user, Playlist $playlist)
    {
        return $user->id == $playlist->user_id;
    }
}
