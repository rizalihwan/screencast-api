<?php

namespace App\Http\Controllers\Screencast;

use App\Http\Controllers\Controller;
use App\Http\Services\Tag\{TagCommands, TagQueries};
use App\Models\Screencast\Tag;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TagController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:edit-tags')->only(['edit', 'update', 'destroy']);
        $this->middleware('permission:create-tags')->only(['index', 'store']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('screencast.tags.index', [
            'tags' => TagQueries::getTagWithPaginated(['id', 'DESC'], 5)
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
            $data = request()->except(['_token']);
            $validator = Validator::make(
                $data,
                array_merge(TagQueries::$rules, [
                    'slug' => 'unique:tags,slug'
                ]),
                TagQueries::$mesaages,
                TagQueries::$attributes
            );

            if ($validator->fails()) {
                return $this->respondWithErrors('screencast.tags.index', $validator, 'tag_store');
            }

            $tag_names = TagQueries::getAllTag()->pluck('name');
            $recorded = [];
            foreach ($tag_names as $origin) {
                array_push($recorded, strtolower($origin));
            }

            if (in_array(strtolower($data['name']), $recorded)) {
                return redirect()->route('screencast.tags.index')
                    ->withErrors(['errorNameExists' => 'Nama tag ini sudah anda gunakan'])
                    ->withInput($data);
            }

            DB::transaction(function () use ($data) {
                $data['slug'] = $this->generateSlug($data['name']);
                TagCommands::create($data);
            });

            return $this->respondRedirectMessage('screencast.tags.index', 'success', 'Data berhasil disimpan');
        } catch (\Exception $e) {
            return $this->respondRedirectMessage('screencast.tags.index', 'error', "{$e->getMessage()}, {$e->getCode()}");
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Tag $tag)
    {
        if (empty($tag)) {
            abort(404, "NOT FOUND");
        }

        dd($tag);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Tag $tag)
    {
        if (empty($tag)) {
            abort(404, "NOT FOUND");
        }

        return view('screencast.tags.edit', compact('tag'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Tag $tag)
    {
        try {
            $data = request()->except(['_token']);

            $validator = Validator::make(
                $data,
                TagQueries::$rules,
                TagQueries::$mesaages,
                TagQueries::$attributes
            );

            if ($validator->fails()) {
                return redirect()->route('screencast.tags.edit', $tag)->withErrors($validator, 'tag_update');
            }

            if (strtolower($tag->name) !== strtolower($data['name'])) {
                $tag_names = TagQueries::getAllTag()->pluck('name');
                $recorded = [];
                foreach ($tag_names as $origin) {
                    array_push($recorded, strtolower($origin));
                }

                if (in_array(strtolower($data['name']), $recorded)) {
                    return redirect()->route('screencast.tags.edit', $tag)
                        ->withErrors(['errorNameExists' => 'Nama tag ini sudah anda gunakan'])
                        ->withInput($data);
                }
            }

            DB::transaction(function () use ($tag, $data) {
                TagCommands::update($tag, $data);
            });

            return redirect()->route('screencast.tags.edit', $tag)->with('success', 'Data berhasil diubah');
        } catch (\Exception $e) {
            return redirect()->route('screencast.tags.edit', $tag)->with('error', "{$e->getMessage()}, {$e->getCode()}");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tag $tag)
    {
        try {
            if (empty($tag)) {
                abort(404, "NOT FOUND");
            }

            TagCommands::delete($tag);

            return $this->respondRedirectMessage('screencast.tags.index', 'success', 'Data berhasil dihapus');
        } catch (\Exception $e) {
            return $this->respondRedirectMessage('screencast.tags.index', 'error', "{$e->getMessage()}");
        }
    }
}
