<?php

declare(strict_types=1);

namespace Honed\Form;

use Honed\Core\Primitive;
use Illuminate\Support\Arr;
use Honed\Form\Concerns\HasLib;
use Honed\Form\Contracts\ToForm;
use Honed\Core\Concerns\HasMethod;
use Honed\Form\Concerns\HasAction;
use Honed\Form\Concerns\HasSchema;
use Honed\Form\Concerns\Cancellable;
use Illuminate\Database\Eloquent\Model;
use Honed\Core\Contracts\NullsAsUndefined;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class Form extends Primitive implements NullsAsUndefined
{
    use HasSchema;
    use Cancellable;
    use HasLib;
    use HasMethod;
    use HasAction;

    /**
     * Create a new form instance.
     * 
     * @param array<int, \Honed\Form\Abstracts\Component> $schema
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