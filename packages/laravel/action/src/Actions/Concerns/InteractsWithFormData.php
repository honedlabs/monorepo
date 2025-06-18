<?php

declare(strict_types=1);

namespace Honed\Action\Actions\Concerns;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\ValidatedInput;

/**
 * @template TInput of mixed
 */
trait InteractsWithFormData
{
    /**
     * Normalize the input data.
     *
     * @param  TInput  $input
     * @return array<string, mixed>
     */
    protected function normalize($input)
    {
        return match (true) {
            $input instanceof Arrayable => $input->toArray(),
            $input instanceof ValidatedInput => $input->all(), // @phpstan-ignore instanceof.alwaysFalse
            $input instanceof FormRequest => $input->safe()->all(), // @phpstan-ignore instanceof.alwaysFalse
            default => $input,
        };
    }

    /**
     * Get the validated input data.
     *
     * @param  TInput  $input
     * @return ValidatedInput
     */
    protected function input($input)
    {
        return match (true) {
            $input instanceof FormRequest => $input->safe(),
            $input instanceof ValidatedInput => $input,
            default => new ValidatedInput($input),
        };
    }
}
