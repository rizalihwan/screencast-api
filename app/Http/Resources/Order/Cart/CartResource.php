<?php

namespace App\Http\Resources\Order\Cart;

use App\Models\Screencast\Playlist;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $user = User::where('id', $this->user_id)->first(['id', 'name', 'email']);
        $playlist = Playlist::where('id', $this->playlist_id)->first(['id', 'name', 'price', 'description']);

        return [
            'id' => $this->id,
            'user' => $user,
            'playlist' => $playlist,
            'created_at' => $this->formatTime($this->created_at),
            'updated_at' => $this->formatTime($this->updated_at)
        ];
    }

    private function formatTime($time)
    {
        $timstamptz = Carbon::createFromFormat('Y-m-d H:i:s', $time)->setTimezone('Asia/Jakarta')->timestamp;
        return date('Y-m-d H:i:s', $timstamptz);
    }
}
