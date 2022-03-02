<?php

namespace App\Http\Controllers\Screencast;

use App\Http\Controllers\Controller;
use App\Http\Services\Playlist\{PlaylistCommands, PlaylistQueries};
use App\Http\Services\Tag\TagQueries;
use App\Models\Screencast\Playlist;
use App\Traits\SlugBaseEntity;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Cache;

class PlaylistController extends Controller
{
    use SlugBaseEntity;

    public function __construct()
    {
        $this->data = [
            'price' => request('price'),
            'name' => request('name'),
            'thumbnail' => request('thumbnail'),
            'description' => request('description'),
            'tags' => request('tags')
        ];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Cache::remember("playlists", 10 * 60, function () {
            return PlaylistQueries::getDataWithPaginated(['id', 'DESC'], 10);
        });

        return view('screencast.playlists.index', [
            'playlists' => $data,
            'tags' => TagQueries::getAllTag()
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
    public function store()
    {
        try {
            $validator = Validator::make(
                request()->except(['_token']),
                array_merge(PlaylistQueries::$rules, [
                    'slug' => 'unique:playlists,slug',
                    'user_id' => 'exists:users,id',
                    'tags' => 'exists:tags,id'
                ]),
                PlaylistQueries::$mesaages,
                PlaylistQueries::$attributes
            );

            if ($validator->fails()) {
                return $this->respondWithErrors('screencast.playlists.index', $validator, 'playlist_store');
            }

            if (Auth::check()) {
                $userID = $this->getUser()->id;
            } else {
                if (!method_exists($this, respondRedirectMessage())) throw new Exception("System Error", 500);
                else return $this->respondRedirectMessage('screencast.playlists.index', 'error', 'User ID Tidak Valid.');
            }

            DB::transaction(function () use ($userID) {
                $playlist = PlaylistCommands::create([
                    'user_id' => $userID,
                    'name' => $this->data['name'],
                    'thumbnail' => $this->data['thumbnail'] ? PlaylistCommands::thumbnailStore('thumbnail') : null,
                    'slug' => $this->generateSlug($this->data['name']),
                    'description' =>  $this->data['description'],
                    'price' =>  $this->overwritePriceFormat($this->data['price'])
                ]);
                $playlist->tags()->attach($this->data['tags']);
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
    public function show(Playlist $playlist)
    {
        if (empty($playlist)) {
            abort(404, "NOT FOUND");
        }

        dd($playlist);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Playlist $playlist)
    {
        $this->authorize('optionAccessRights', $playlist);

        if (empty($playlist)) {
            abort(404, "NOT FOUND");
        }

        $data = PlaylistQueries::getOnePlaylist($playlist);
        Redis::set('playlist_' . $playlist, $data);

        return view('screencast.playlists.edit', [
            'playlist' => $data,
            'tags' => TagQueries::getAllTag()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Playlist $playlist)
    {
        $this->authorize('optionAccessRights', $playlist);

        try {
            $data = request()->except(['_token', 'tags']);

            $validator = Validator::make(
                $data,
                PlaylistQueries::$rules,
                PlaylistQueries::$mesaages,
                PlaylistQueries::$attributes
            );

            if ($validator->fails()) {
                return redirect()->route('screencast.playlists.edit', $playlist)->withErrors($validator, 'playlist_update');
            }

            DB::transaction(function () use ($playlist, $data) {
                $data['price'] = $this->overwritePriceFormat($this->data['price']);
                PlaylistCommands::update($playlist, $data);
                if ($this->data['tags']) {
                    $playlist->tags()->sync($this->data['tags']);
                }
            });

            return redirect()->route('screencast.playlists.edit', $playlist)->with('success', 'Data berhasil diubah');
        } catch (\Exception $e) {
            return redirect()->route('screencast.playlists.edit', $playlist)->with('error', "{$e->getMessage()}, {$e->getCode()}");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Playlist $playlist)
    {
        $this->authorize('optionAccessRights', $playlist);

        try {
            if (empty($playlist)) {
                abort(404, "NOT FOUND");
            }

            $playlist->tags()->detach();
            PlaylistCommands::delete($playlist);

            return $this->respondRedirectMessage('screencast.playlists.index', 'success', 'Data berhasil dihapus');
        } catch (\Exception $e) {
            return $this->respondRedirectMessage('screencast.playlists.index', 'error', "{$e->getMessage()}");
        }
    }
}
