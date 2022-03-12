<?php

namespace App\Http\Services\Order\Cart;

use App\Http\Services\Service;
use App\Models\Order\Cart;
use Exception;

class CartQueries extends Service
{
    public static function getListCart()
    {
        try {
            return auth()->user()->carts()->get();
        } catch (Exception $th) {
            if (in_array($th->getCode(), self::$error_codes)) {
                throw new Exception($th->getMessage(), $th->getCode());
            }
            throw new Exception($th->getMessage(), 500);
        }
    }
}
