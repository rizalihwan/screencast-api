<?php

namespace App\Traits;

use App\Http\Controllers\Controller;
use Str;
use Exception;

/**
 * SlugBaseEntity
 */
trait SlugBaseEntity
{
    public function generateSlug(string $data)
    {
        try {
            $ctr = new Controller();
            return (string) "scrcst-" . Str::slug($data . '-' . strtolower(Str::random(20))) . "-{$ctr->getUser()->id}";
        } catch (Exception $ex) {
            throw new Exception("Slug generate not responding! {$ex->getMessage} - Status Code : {$ex->getCode}");
        }
    }
}
