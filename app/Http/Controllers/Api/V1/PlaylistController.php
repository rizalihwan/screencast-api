<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Screencast\PlaylistResource;
use App\Models\Screencast\Playlist;
use Exception;

class PlaylistController extends Controller
{
    public function getAllPlaylist()
    {
        try {
            $playlists =  Playlist::with(['user'])
                ->withCount(['videos as countVideos'])
                ->latest()->paginate(5);

            return $this->respondWithData(true, 'Data berhasil di dapatkan', 200, PlaylistResource::collection($playlists));
        } catch (Exception $ex) {
            throw new Exception($ex->getMessage(), 500);
        }
    }

    public function detailPlaylist($playlist_slug)
    {
        try {
            $playlist =  Playlist::with(['user'])
                ->withCount(['videos as countVideos'])
                ->where('slug', $playlist_slug)->first();

            if (empty($playlist)) {
                return $this->respondWithData(false, 'Data tidak di temukan.', 404, []);
            }

            return $this->respondWithData(true, 'Data berhasil di dapatkan', 200, new PlaylistResource($playlist));
        } catch (Exception $ex) {
            throw new Exception($ex->getMessage(), 500);
        }
    }
}
