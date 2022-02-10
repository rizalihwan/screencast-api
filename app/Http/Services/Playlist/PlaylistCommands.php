<?php

namespace App\Http\Services\Playlist;

use App\Http\Services\Service;
use App\Models\Screencast\Playlist;
use Exception;

class PlaylistCommands extends Service
{
    public static function create(array $field)
    {
        try {
            return Playlist::create($field);
        } catch (Exception $th) {
            if (in_array($th->getCode(), self::$error_codes)) {
                throw new Exception($th->getMessage(), $th->getCode());
            }
            throw new Exception($th->getMessage(), 500);
        }
    }

    public static function thumbnailStore($thumb)
    {
        try {
            return request()->file($thumb)->store("images/playlist");
        } catch (Exception $th) {
            if (in_array($th->getCode(), self::$error_codes)) {
                throw new Exception($th->getMessage(), $th->getCode());
            }
            throw new Exception($th->getMessage(), 500);
        }
    }

    public static function update($playlist, array $field)
    {
        try {
            if (isset($field['thumbnail'])) {
                \Storage::delete($playlist->thumbnail);
                $field['thumbnail'] = self::thumbnailStore('thumbnail');
            } else {
                $field['thumbnail'] = $playlist->thumbnail;
            }

            return !$playlist ? abort(404, "Not Found") : $playlist->update($field);
        } catch (Exception $th) {
            if (in_array($th->getCode(), self::$error_codes)) {
                throw new Exception($th->getMessage(), $th->getCode());
            }
            throw new Exception($th->getMessage(), 500);
        }
    }

    public static function delete($playlist)
    {
        try {
            if ($playlist->thumbnail) \Storage::delete($playlist->thumbnail);
            $playlist->delete();
        } catch (Exception $th) {
            if (in_array($th->getCode(), self::$error_codes)) {
                throw new Exception($th->getMessage(), $th->getCode());
            }
            throw new Exception($th->getMessage(), 500);
        }
    }
}
