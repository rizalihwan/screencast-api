<?php

namespace App\Http\Controllers\Screencast;

use App\Http\Controllers\Controller;
use App\Http\Services\Video\{VideoCommands, VideoQueries};
use App\Models\Screencast\{Playlist, Video};
use App\Traits\SlugBaseEntity;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class VideoController extends Controller
{
    use SlugBaseEntity;

    protected static function preventDuplication($model, $column)
    {
        $videos = $model->videos()->pluck($column);
        $recorded = [];

        foreach ($videos as $origin) {
            array_push($recorded, (int)$origin);
        }

        return $recorded;
    }

    public function create(Playlist $playlist)
    {
        $this->authorize('optionAccessRights', $playlist);

        return view('screencast.videos.index', [
            'playlist' => $playlist,
            'playlist_name' => "Playlist : {$playlist->name}",
            'videos' => VideoQueries::getListVideoByPlaylist($playlist->id, ['episode', 'ASC'], 3)
        ]);
    }

    public function store(Playlist $playlist)
    {
        $this->authorize('optionAccessRights', $playlist);

        try {
            $data = request()->except(['_token']);

            $rules = array_merge(VideoQueries::$rules, [
                'slug' => 'unique:videos,slug',
                'playlist_id' => 'exists:playlists,id'
            ]);

            if (in_array((int)$data['episode'], self::preventDuplication($playlist, 'episode'))) {
                $rules = array_merge($rules, [
                    'episode' => 'required|numeric|unique:videos,episode'
                ]);
            }

            $validator = Validator::make(
                $data,
                $rules,
                VideoQueries::$mesaages,
                VideoQueries::$attributes
            );

            if ($validator->fails()) {
                return redirect()->route('screencast.videos.create', $playlist)
                    ->withErrors($validator, 'video_store')
                    ->withInput();
            }

            $data = array_merge($data, [
                'is_intro' => request('is_intro')
            ]);

            if ($data['is_intro'] || !empty($data['is_intro']) || $data['is_intro'] == 1 || $data['is_intro'] != null) {
                if (in_array((int)$data['is_intro'], self::preventDuplication($playlist, 'is_intro'))) {
                    return redirect()->route('screencast.videos.create', $playlist)
                        ->with('warning', 'Intro sudah di pilih sebelumnya pada playlist ini, anda tidak bisa memilih intro lebih dari 1.')
                        ->withInput();
                } else {
                    $data['is_intro'] = 1;
                }
            } else {
                $data['is_intro'] = 0;
            }

            DB::transaction(function () use ($playlist, $data) {
                $data['slug'] = $this->generateSlug($data['title']);
                VideoCommands::create($playlist, $data);
            });

            return redirect()->route('screencast.videos.create', $playlist)->with('success', 'Data berhasil disimpan');
        } catch (\Exception $e) {
            return $this->respondRedirectMessage('screencast.playlists.index', 'error', "{$e->getMessage()}, {$e->getCode()}");
        }
    }

    public function show(Video $video)
    {
        if (empty($video)) {
            abort(404, "NOT FOUND");
        }

        dd($video);
    }

    public function edit(Video $video, Playlist $playlist)
    {
        $this->authorize('optionAccessRights', $playlist);

        if (in_array((int)1, self::preventDuplication($playlist, 'is_intro'))) {
            $htmlCheckedIntro = [
                'attribute' => 'disabled',
                'label' => 'Intro Available.'
            ];
        } else {
            $htmlCheckedIntro = [
                'attribute' => false,
                'label' => 'Make Intro'
            ];
        }

        return view('screencast.videos.edit', [
            'playlist' => $playlist,
            'htmlCheckedIntro' => $htmlCheckedIntro,
            'video' => VideoQueries::getOneVideo($video)
        ]);
    }

    public function update(Video $video, Playlist $playlist)
    {
        // something like that
    }

    public function destroy(Video $video, Playlist $playlist)
    {
        try {
            if (empty($video)) {
                abort(404, "NOT FOUND");
            }

            VideoCommands::delete($video);

            return redirect()->route('screencast.videos.create', $playlist)
                ->with('success', 'Data berhasil di Hapus');
        } catch (\Exception $e) {
            return redirect()->route('screencast.videos.create', $playlist)
                ->with('error', $e->getMessage());
        }
    }
}
