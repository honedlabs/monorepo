<?php

declare(strict_types=1);

namespace Honed\Action\Http\Data;

use Honed\Core\Contracts\Transfer;

class InlineData implements Transfer
{
    public function __construct(
        public readonly string $name,
        public readonly int|string $id,
    ) {}

    /**
     * @param \Honed\Action\Http\Requests\ActionRequest $request
     */
    public static function from($request)
    {
        return resolve(BulkData::class, [
            'name' => $request->input('name'),
            'id' => $request->input('id'),
        ]);
    }
}