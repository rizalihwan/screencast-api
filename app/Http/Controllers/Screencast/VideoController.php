<?php

namespace App\Http\Controllers\Screencast;

use App\Http\Controllers\Controller;
use App\Http\Services\Video\VideoCommands;
use App\Http\Services\Video\VideoQueries;
use App\Models\Screencast\Playlist;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class VideoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('screencast.videos.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Playlist $playlist)
    {
        return view('screencast.videos.index', [
            'playlist' => $playlist,
            'playlist_name' => "Playlist : {$playlist->name}"
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Playlist $playlist)
    {
        try {
            $data = request()->except(['_token']);
            $validator = Validator::make(
                $data,
                array_merge(VideoQueries::$rules, [
                    'slug' => 'unique:videos,slug',
                    'playlist_id' => 'exists:playlists,id'
                ]),
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

            DB::transaction(function () use ($playlist, $data) {
                $data['slug'] = \Str::slug($data['title'] . '-' . strtolower(\Str::random(20)));
                ($data['is_intro'] || !empty($data['is_intro']) || $data['is_intro'] == 1) ? true : false;
                VideoCommands::create($playlist, $data);
            });

            return $this->respondRedirectMessage('screencast.playlists.index', 'success', 'Data berhasil disimpan');
        } catch (\Exception $e) {
            return $this->respondRedirectMessage('screencast.playlists.index', 'error', "{$e->getMessage()}, {$e->getCode()}");
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('screencast.videos.index');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
