<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Services\Video\VideoQueries;
use Exception;

class VideoController extends Controller
{
    public function getVideoByPlaylist($playlist_slug)
    {
        try {
            return VideoQueries::getVideoByPlaylist($playlist_slug);
        } catch (Exception $ex) {
            throw new Exception($ex->getMessage(), $ex->getCode());
        }
    }

    public function detailVideo($playlist_slug, $video_episode)
    {
        try {
            return VideoQueries::getOneVideoByEps($playlist_slug, $video_episode);
        } catch (Exception $ex) {
            throw new Exception($ex->getMessage(), $ex->getCode());
        }
    }
}
