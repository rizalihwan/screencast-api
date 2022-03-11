<?php

namespace App\Http\Services\Video;

use App\Http\Controllers\Controller;
use App\Http\Resources\Screencast\VideoResource;
use App\Http\Services\Service;
use App\Models\Screencast\Playlist;
use App\Models\Screencast\Video;
use Exception;

class VideoQueries extends Service
{
    static $rules = [
        'title' => 'required|max:50|min:3',
        'description' => 'required|max:200|min:10',
        'video_path_url' => 'required|url',
        'runtime' => 'required',
        'is_intro' => 'nullable'
    ];

    static $mesaages = [
        'required' => ':attribute tidak boleh kosong',
        'min' => ':attribute minimal :min karakter',
        'max' => ':attribute maximal :max karakter',
        'numeric' => ':attribute yang dimasukan harus angka',
        'url' => ':attribute yang dimasukan harus berupa alamat url',
        'unique' => ':attribute sudah ada'
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

    public static function getListVideoByPlaylist(int $key, array $orderBy = ['id', 'ASC'], int $paginated = 5)
    {
        try {
            return Video::where('playlist_id', $key)
                ->with(['playlist'])
                ->orderBy($orderBy[0], $orderBy[1])
                ->paginate($paginated);
        } catch (Exception $th) {
            if (in_array($th->getCode(), self::$error_codes)) {
                throw new Exception($th->getMessage(), $th->getCode());
            }
            throw new Exception($th->getMessage(), 500);
        }
    }

    public static function getOneVideo($video)
    {
        try {
            return $video;
        } catch (Exception $th) {
            if (in_array($th->getCode(), self::$error_codes)) {
                throw new Exception($th->getMessage(), $th->getCode());
            }
            throw new Exception($th->getMessage(), 500);
        }
    }

    public static function getVideoByPlaylist($playlist_slug)
    {
        try {
            $playlist = Playlist::with(['videos'])->where('slug', $playlist_slug)->first();

            if (empty($playlist)) {
                return self::ctr()->respondWithData(false, 'Data tidak di temukan.', 404, []);
            }

            return self::ctr()->respondWithData(
                true,
                'Berhasil mendapatkan data',
                200,
                VideoResource::collection($playlist->videos()->orderBy('episode')->get())
            );
        } catch (Exception $th) {
            if (in_array($th->getCode(), self::$error_codes)) {
                throw new Exception($th->getMessage(), $th->getCode());
            }
            throw new Exception($th->getMessage(), 500);
        }
    }

    public static function getOneVideoByEps($playlist_slug, int $episode)
    {
        try {
            if ($episode == 0 || $episode == false) {
                return self::ctr()->respondWithData(false, 'Episode tidak boleh kosong.', 404, []);
            }
            $playlist = Playlist::with(['videos'])->where('slug', $playlist_slug)->first();

            if (empty($playlist)) {
                return self::ctr()->respondWithData(false, 'Data tidak di temukan.', 404, []);
            }

            $video = $playlist->videos()->where('episode', $episode)->first();

            if (!$video) {
                return self::ctr()->respondWithData(false, 'Episode pada playlist ini tidak ditemukan.', 404, []);
            } else {
                if (auth()->user()->hasBought($playlist) || $video->is_intro == 1) {
                    return self::ctr()->respondWithData(
                        true,
                        'Berhasil mendapatkan data',
                        200,
                        new VideoResource($video)
                    );
                }

                return self::ctr()->respondWithData(false, 'You have to buy before you watch.', 200, []);
            }
        } catch (Exception $th) {
            if (in_array($th->getCode(), self::$error_codes)) {
                throw new Exception($th->getMessage(), $th->getCode());
            }
            throw new Exception($th->getMessage(), 500);
        }
    }
}
