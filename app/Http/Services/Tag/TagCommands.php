<?php

namespace App\Http\Services\Tag;

use App\Http\Services\Service;
use App\Models\Screencast\Tag;
use Exception;

class TagCommands extends Service
{
    public static function create(array $field)
    {
        try {
            return Tag::create($field);
        } catch (Exception $th) {
            if (in_array($th->getCode(), self::$error_codes)) {
                throw new Exception($th->getMessage(), $th->getCode());
            }
            throw new Exception($th->getMessage(), 500);
        }
    }

    public static function update($tag, array $field)
    {
        try {
            return !$tag ? abort(404, "Not Found") : $tag->update($field);
        } catch (Exception $th) {
            if (in_array($th->getCode(), self::$error_codes)) {
                throw new Exception($th->getMessage(), $th->getCode());
            }
            throw new Exception($th->getMessage(), 500);
        }
    }

    public static function delete($tag)
    {
        try {
            $tag->playlists()->detach();
            $tag->delete();
        } catch (Exception $th) {
            if (in_array($th->getCode(), self::$error_codes)) {
                throw new Exception($th->getMessage(), $th->getCode());
            }
            throw new Exception($th->getMessage(), 500);
        }
    }
}
