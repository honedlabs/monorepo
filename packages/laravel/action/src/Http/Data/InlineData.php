<?php

declare(strict_types=1);

namespace Honed\Action\Http\Data;

class InlineData extends ActionData
{
    public function __construct(
        string $name,
        public readonly int|string $id,
    ) {
        parent::__construct($name);
    }

    /**
     * Create a new inline data transfer object.
     *
     * @param  \Honed\Action\Http\Requests\ActionRequest  $request
     */
    public static function from($request): static
    {
        return resolve(InlineData::class, [
            'name' => $request->validated('name'),
            'id' => $request->validated('id'),
        ]);
    }
}
