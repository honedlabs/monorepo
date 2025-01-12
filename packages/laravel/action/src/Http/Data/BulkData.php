<?php

declare(strict_types=1);

namespace Honed\Action\Http\Data;

class BulkData extends ActionData
{
    /**
     * @param  array<int,string|int>  $only
     * @param  array<int,string|int>  $except
     */
    public function __construct(
        string $name,
        public readonly array $only,
        public readonly array $except,
        public readonly bool $all,
    ) {
        parent::__construct($name);
    }

    /**
     * Create a new bulk data transfer object.
     *
     * @param  \Honed\Action\Http\Requests\ActionRequest  $request
     */
    public static function from($request): static
    {
        return resolve(BulkData::class, [
            'name' => $request->validated('name'),
            'except' => $request->validated('except'),
            'only' => $request->validated('only'),
            'all' => $request->validated('all'),
        ]);
    }
}
