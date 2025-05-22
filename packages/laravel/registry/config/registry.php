<?php

return [
    'schema' => env('REGISTRY_SCHEMA', 'https://ui.shadcn.com/schema/registry.json'),

    'name' => env('APP_NAME', 'Registry'),

    'homepage' => env('REGISTRY_HOMEPAGE', config('APP_URL')),

    'author' => env('REGISTRY_AUTHOR'),

    'registry_path' => env('REGISTRY_PATH', 'registry'),

    'path' => resource_path('js/registry'),
];