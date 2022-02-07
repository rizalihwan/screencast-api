<?php

namespace App\Http\Services\Tag;

use App\Http\Services\Service;
use App\Models\Screencast\Tag;

class TagQueries extends Service
{
    public static function getAllTag()
    {
        return Tag::get(['id', 'name']);
    }
}
