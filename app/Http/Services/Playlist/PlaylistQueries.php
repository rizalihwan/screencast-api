<?php

namespace App\Http\Services\Playlist;

use App\Http\Services\Service;
use App\Models\Screencast\Playlist;

class PlaylistQueries extends Service
{
    static $rules = [
        'thumbnail' => 'nullable|max:2048',
        'name' => 'required|max:50|min:3',
        'description' => 'required|max:200|min:10',
        'price' => 'required|numeric'
    ];

    static $mesaages = [
        'required' => ':attribute tidak boleh kosong',
        'min' => ':attribute minimal :min karakter',
        'unique' => ':attribute yang dimasukan sudah ada!',
        'max' => ':attribute maximal :max karakter'
    ];

    static $attributes = [
        'thumbnail' => 'Gambar',
        'name' => 'Nama',
        'description' => 'Deskripsi',
        'price' => 'Harga',
        'user_id' => 'Author'
    ];

    public static function getDataWithPaginated($orderBy = ['id', 'ASC'], int $paginated = 5)
    {
        return Playlist::orderBy($orderBy[0], $orderBy[1])->paginate($paginated);
    }

    public static function getOnePlaylist(int $key)
    {
        $playlist = Playlist::findOrFail($key);

        return $playlist;
    }
}
