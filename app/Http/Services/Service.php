<?php

namespace App\Http\Services;

class Service
{
    static $error_codes = [400, 401, 402, 403, 404, 405, 406, 407, 408, 409, 410, 411, 412, 413, 414, 415, 416, 417, 418, 421, 422, 423, 424, 425, 426, 428, 429, 431, 451, 500, 501, 502, 503, 504, 505, 506, 507, 508, 510, 511];

    static function ctr()
    {
        try {
            return new \App\Http\Controllers\Controller;
        } catch (\Exception $th) {
            if(in_array($th->getCode(), self::$error_codes)) {
                throw new \Exception("Controller class is error. {$th->getMessage()}", $th->getCode());
            }
            throw new \Exception("Controller class is error. {$th->getMessage()}", 500);
        }
    }
}
