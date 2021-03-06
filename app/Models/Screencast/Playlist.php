<?php

namespace App\Models\Screencast;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Playlist extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function videos()
    {
        return $this->hasMany(Video::class);
    }

    public function user_purchases()
    {
        return $this->belongsToMany(User::class, 'purchased_playlist', 'playlist_id', 'user_id');
    }

    public function scopeShowThumbnail()
    {
        $thumb = $this->thumbnail;
        if(!is_null($thumb)) $result = "/storage/" . $thumb;
        return $result;
    }
}
