<?php

namespace App\Http\Services\Playlist;

use App\Http\Services\Service;
use App\Models\Screencast\Playlist;

class PlaylistCommands extends Service
{
    public static function create(array $field)
    {
        return Playlist::create($field);
    }

    public static function thumbnailStore($thumb)
    {
        return request()->file($thumb)->store("images/playlist");
    }

    public static function update($playlist, array $field)
    {
        if (isset($field['thumbnail'])) {
            \Storage::delete($playlist->thumbnail);
            $field['thumbnail'] = self::thumbnailStore('thumbnail');
        } else {
            $field['thumbnail'] = $playlist->thumbnail;
        }

        return !$playlist ? abort(404, "Not Found") : $playlist->update($field);
    }

    public static function delete($playlist)
    {
        if ($playlist->thumbnail) \Storage::delete($playlist->thumbnail);
        return !$playlist ? abort(404, "Not Found") : $playlist->delete();
    }
}
