<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Screencast\PlaylistResource;
use App\Http\Services\Playlist\PlaylistQueries;
use Exception;

class PlaylistController extends Controller
{
    public function getAllPlaylist()
    {
        try {
            return $this->respondWithData(
                true,
                'Data berhasil di dapatkan',
                200,
                PlaylistResource::collection(PlaylistQueries::immutableInitialData()->latest()->paginate(5))
            );
        } catch (Exception $ex) {
            throw new Exception($ex->getMessage(), 500);
        }
    }

    public function detailPlaylist($playlist_slug)
    {
        try {
            $playlist =  PlaylistQueries::immutableInitialData()->where('slug', $playlist_slug)->first();

            if (empty($playlist)) {
                return $this->respondWithData(false, 'Data tidak di temukan.', 404, []);
            }

            return $this->respondWithData(
                true,
                'Data berhasil di dapatkan',
                200,
                new PlaylistResource($playlist)
            );
        } catch (Exception $ex) {
            throw new Exception($ex->getMessage(), 500);
        }
    }
}
