<?php

namespace App\Http\Services\Playlist;

use App\Http\Services\Service;

class PlaylistQueries extends Service
{
    static $rules = [
        // 'thumbnail' => 'nullable|max:2048|mimes:jpg,png,jpeg',
        'name' => 'required|max:50|min:3',
        'description' => 'required|max:200|min:10',
        'price' => 'required'
    ];

    static $mesaages = [
        'required' => ':attribute tidak boleh kosong',
        'min' => ':attribute minimal :min karakter',
        'unique' => ':attribute yang dimasukan sudah ada!',
        'max' => ':attribute maximan :max karakter'
    ];

    static $attributes = [
        'thumbnail' => 'Gambar',
        'name' => 'Nama',
        'description' => 'Deskripsi',
        'price' => 'Harga',
        'user_id' => 'Author'
    ];

}