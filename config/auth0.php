<?php

return [
    'domain' => env('AUTH0_DOMAIN', 'no-domain'),
    'client_id' => env('AUTH0_CLIENT_ID', 'no-client-id'),
    'client_secret' => env('AUTH0_CLIENT_SECRET', 'no-client-secret'),
    'audience' => env('AUTH0_AUDIENCE', 'no-audience'),
    'cookie_secret' => env('AUTH0_COOKIE_SECRET', 'no-cookie-secret'),
];
