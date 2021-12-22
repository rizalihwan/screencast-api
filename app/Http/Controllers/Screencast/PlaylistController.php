<?php

namespace App\Http\Controllers\Screencast;

use App\Http\Controllers\Controller;
use App\Http\Services\Playlist\{PlaylistCommands, PlaylistQueries};
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PlaylistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('screencast.playlists.index', [
            'playlists' => PlaylistQueries::getDataWithPaginated(['id', 'DESC'], 10)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $data = $request->except(['_token']);
            $data['slug'] = \Str::slug($data['name'] . '-' . strtolower(\Str::random(20)));
            $data['thumbnail'] = isset($data['thumbnail']) ? PlaylistCommands::thumbnailStore('thumbnail') : null;

            if (Auth::check()) {
                $data['user_id'] = Auth::id();
            } else {
                if (!method_exists($this, respondRedirectMessage())) throw new Exception("System Error", 500);
                else return $this->respondRedirectMessage('screencast.playlists.index', 'error', 'User ID Tidak Valid.');
            }

            $validator = Validator::make(
                $data,
                array_merge(PlaylistQueries::$rules, [
                    'slug' => 'required|unique:playlists,slug',
                    'user_id' => 'required|exists:users,id',
                ]),
                PlaylistQueries::$mesaages,
                PlaylistQueries::$attributes
            );

            if ($validator->fails()) {
                return $this->respondWithErrors('screencast.playlists.index', $validator, 'playlist_store');
            }

            PlaylistCommands::create($data);
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
        return view('screencast.playlists.edit', [
            'playlist' => PlaylistQueries::getOnePlaylist($id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $data = $request->except(['_token']);

            $validator = Validator::make(
                $data,
                PlaylistQueries::$rules,
                PlaylistQueries::$mesaages,
                PlaylistQueries::$attributes
            );

            if ($validator->fails()) {
                return redirect()->route('screencast.playlists.edit', $id)->withErrors($validator, 'playlist_update');
            }

            PlaylistCommands::update($id, $data);
            return redirect()->route('screencast.playlists.edit', $id)->with('success', 'Data berhasil diubah');
        } catch (\Exception $e) {
            return redirect()->route('screencast.playlists.edit', $id)->with('error', "{$e->getMessage()}, {$e->getCode()}");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            PlaylistCommands::delete($id);
            return $this->respondRedirectMessage('screencast.playlists.index', 'success', 'Data berhasil dihapus');
        } catch (\Exception $e) {
            return $this->respondRedirectMessage('screencast.playlists.index', 'error', "{$e->getMessage()}");
        }
    }
}
