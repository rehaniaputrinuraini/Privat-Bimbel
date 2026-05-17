<?php

use Vinkla\Hashids\Facades\Hashids;

if (!function_exists('hash_id')) {
    function hash_id($id)
    {
        return Hashids::encode($id);
    }
}

if (!function_exists('unhash_id')) {
    function unhash_id($hash)
    {
        $decoded = Hashids::decode($hash);
        return $decoded[0] ?? null;
    }
}