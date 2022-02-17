<?php

namespace App\Http\Services\Video;

use App\Http\Services\Service;
use Exception;

class VideoCommands extends Service
{
    public static function create($playlist, array $field)
    {
        try {
            return $playlist->videos()->create($field);
        } catch (Exception $th) {
            if (in_array($th->getCode(), self::$error_codes)) {
                throw new Exception($th->getMessage(), $th->getCode());
            }
            throw new Exception($th->getMessage(), 500);
        }
    }
}
