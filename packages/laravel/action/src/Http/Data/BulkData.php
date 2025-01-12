<?php

declare(strict_types=1);

namespace Honed\Action\Http\Data;

use Honed\Core\Contracts\Transfer;

class BulkData implements Transfer
{
    public function __construct(
        public readonly string $name,
        public readonly array $only,
        public readonly array $except,
        public readonly bool $all,
    ) {}

    /**
     * @param \Honed\Action\Http\Requests\ActionRequest $request
     */
    public static function from($request)
    {
        return resolve(BulkData::class, [
            'name' => $request->input('name'),
            'except' => $request->input('except'),
            'only' => $request->input('only'),
            'all' => $request->input('all'),
        ]);
    }
}