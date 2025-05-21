<?php

return [
    'schema' => env('REGISTRY_SCHEMA', config('APP_URL').'/schema'),

    'name' => env('APP_NAME', 'Registry'),

    'homepage' => env('REGISTRY_HOMEPAGE', config('APP_URL')),

];