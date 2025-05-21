<?php

return [
    'schema' => env('REGISTRY_SCHEMA', 'https://ui.shadcn.com/schema/registry-item.json'),

    'name' => env('APP_NAME', 'Registry'),

    'homepage' => env('REGISTRY_HOMEPAGE', config('APP_URL')),

];