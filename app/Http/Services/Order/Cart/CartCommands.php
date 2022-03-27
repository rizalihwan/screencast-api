<?php

namespace App\Http\Services\Order\Cart;

use App\Http\Services\Service;
use Exception;

class CartCommands extends Service
{
    public static function create(array $field)
    {
        try {
            return auth()->user()->carts()->create($field);
        } catch (Exception $th) {
            if (in_array($th->getCode(), self::$error_codes)) {
                throw new Exception($th->getMessage(), $th->getCode());
            }
            throw new Exception($th->getMessage(), 500);
        }
    }
}
