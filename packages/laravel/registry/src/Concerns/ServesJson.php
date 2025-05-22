<?php

declare(strict_types=1);

namespace Honed\Registry\Concerns;

use Illuminate\Support\Facades\App;

trait ServesJson
{
    /**
     * The endpoint to serve the JSON response, will be suffixed with '.json'.
     * 
     * @var string
     */
    protected $endpoint = 'registry';

    /**
     * Serve the JSON response.
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public static function serve()
    {
        $class = App::make(static::class);

        return response()->json($class->toJson());
    }
}