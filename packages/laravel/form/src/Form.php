<?php

declare(strict_types=1);

namespace Honed\Form;

use Honed\Core\Concerns\HasMethod;
use Honed\Core\Contracts\NullsAsUndefined;
use Honed\Core\Primitive;
use Honed\Form\Concerns\Cancellable;
use Honed\Form\Concerns\HasAction;
use Honed\Form\Concerns\HasLib;
use Honed\Form\Concerns\HasSchema;
use Illuminate\Http\Request;

class Form extends Primitive implements NullsAsUndefined
{
    use Cancellable;
    use HasAction;
    use HasLib;
    use HasMethod;
    use HasSchema;

    /**
     * Create a new form instance.
     *
     * @param  array<int, \Honed\Form\Abstracts\Component>  $schema
     */
    public static function make(array $schema = []): static
    {
        return resolve(static::class)->schema($schema);
    }

    /**
     * Provide the instance with any necessary setup.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->method(Request::METHOD_POST);
    }

    /**
     * Get the array representation of the form.
     *
     * @return array<string, mixed>
     */
    protected function representation(): array
    {
        return [
            'schema' => $this->schemaToArray(),
            'lib' => $this->getLib(),
            'method' => $this->getMethod(),
            'action' => $this->getAction(),
            'cancel' => $this->getCancel(),
        ];
    }
}
