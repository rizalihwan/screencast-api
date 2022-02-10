<?php

namespace App\Http\Services\Tag;

use App\Http\Services\Service;
use App\Models\Screencast\Tag;
use Exception;

class TagQueries extends Service
{
    static $rules = [
        'name' => 'required|max:50|min:3'
    ];

    static $mesaages = [
        'required' => ':attribute tidak boleh kosong',
        'min' => ':attribute minimal :min karakter',
        'max' => ':attribute maximal :max karakter'
    ];

    static $attributes = [
        'name' => 'Nama'
    ];

    public static function getTagWithPaginated(array $orderBy = ['id', 'ASC'], int $paginated = 10)
    {
        try {
            return Tag::withCount(['playlists as countPlaylists'])
                ->orderBy($orderBy[0], $orderBy[1])
                ->paginate($paginated);
        } catch (Exception $th) {
            if (in_array($th->getCode(), self::$error_codes)) {
                throw new Exception($th->getMessage(), $th->getCode());
            }
            throw new Exception($th->getMessage(), 500);
        }
    }

    public static function getAllTag()
    {
        try {
            return Tag::get(['id', 'name']);
        } catch (Exception $th) {
            if (in_array($th->getCode(), self::$error_codes)) {
                throw new Exception($th->getMessage(), $th->getCode());
            }
            throw new Exception($th->getMessage(), 500);
        }
    }
}
