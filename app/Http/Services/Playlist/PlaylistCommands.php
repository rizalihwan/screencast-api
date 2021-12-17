<?php

namespace App\Http\Services\Playlist;

use App\Http\Services\Service;
use App\Models\Screencast\Playlist;

class PlaylistCommands extends Service
{
    public static function store(array $field)
    {
        Playlist::create($field);
    }

    public static function thumbnailStore($thumb)
    {
        return request()->file($thumb)->store("images/playlist");
    }
}
