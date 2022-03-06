<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Screencast\PlaylistResource;
use App\Models\Screencast\Playlist;

class PlaylistController extends Controller
{
    public function getAllPlaylist()
    {
        $playlists =  Playlist::with(['user'])
            ->withCount(['videos as countVideos'])
            ->latest()->paginate(5);

        return PlaylistResource::collection($playlists);
    }
}
