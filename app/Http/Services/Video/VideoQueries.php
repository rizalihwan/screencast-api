<?php

namespace App\Http\Services\Video;

use App\Http\Services\Service;
use App\Models\Screencast\Video;
use Exception;

class VideoQueries extends Service
{
    static $rules = [
        'title' => 'required|max:50|min:3',
        'description' => 'required|max:200|min:10',
        'video_path_url' => 'required|url',
        'episode' => 'required|numeric',
        'runtime' => 'required',
        'is_intro' => 'nullable'
    ];

    static $mesaages = [
        'required' => ':attribute tidak boleh kosong',
        'min' => ':attribute minimal :min karakter',
        'max' => ':attribute maximal :max karakter',
        'numeric' => ':attribute yang dimasukan harus angka',
        'url' => ':attribute yang dimasukan harus berupa alamat url'
    ];

    static $attributes = [
        'title' => 'Judul',
        'description' => 'Deskripsi',
        'video_path_url' => 'URL',
        'episode' => 'Episode',
        'runtime' => 'Runtime'
    ];

    public static function getAllVideo()
    {
        try {
            return Video::with(['playlist'])->get();
        } catch (Exception $th) {
            if (in_array($th->getCode(), self::$error_codes)) {
                throw new Exception($th->getMessage(), $th->getCode());
            }
            throw new Exception($th->getMessage(), 500);
        }
    }
}
