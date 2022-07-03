<?php

$ips = env('APP_DEBUG_DYNAMIC_ALLOWED_IPS', '');

return [
    'cookie_name' => env('APP_DEBUG_DYNAMIC_COOKIE_NAME', ''),

    'cookie_secret' => env('APP_DEBUG_DYNAMIC_COOKIE_SECRET', ''),

    'allowed_ips' => (array)preg_split('/,/', $ips, -1, PREG_SPLIT_NO_EMPTY),
];
