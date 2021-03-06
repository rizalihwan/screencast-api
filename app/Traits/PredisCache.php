<?php

namespace App\Traits;

use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Cache;
use Exception;

/**
 * Caching Predis Optimization Query
 */
trait PredisCache
{
    public function predisSetAll(string $prefix, $query)
    {
        try {
            return Cache::remember($prefix, 10 * 60, function () use ($query) {
                return $query;
            });
        } catch (Exception $ex) {
            throw new Exception("Error: Data tidak dapat di peroleh {$ex->getMessage()}", 500);
        }
    }

    public function predisSetOne(string $prefix, $key)
    {
        try {
            return Redis::set($prefix . $key, $key);
        } catch (Exception $ex) {
            throw new Exception("Error: Data tidak dapat di peroleh {$ex->getMessage()}", 500);
        }
    }

    public function predisStoreData(string $prefix, array $data_set)
    {
        $redis = Redis::connection();

        return $redis->set(
            $prefix,
            json_encode($data_set)
        );
    }

    public function predisDeleteData($key)
    {
        return Redis::del($key);
    }
}
