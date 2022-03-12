<?php

namespace App\Http\Resources\Screencast;

use Illuminate\Http\Resources\Json\JsonResource;

class PlaylistResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'slug' => $this->slug,
            'name' => $this->name,
            'description' => $this->description,
            'price' => [
                'origin' => $this->price,
                'formatted' => number_format($this->price, 2, '.', '.')
            ],
            'thumbnail' => $this->thumbnail,
            'author' => $this->user,
            'videos' => $this->videos()->count()
        ];
    }
}
