<?php

declare(strict_types=1);

namespace Honed\Form;

use Closure;
use Honed\Core\Concerns\HasMethod;
use Honed\Core\Contracts\NullsAsUndefined;
use Honed\Core\Primitive;
use Honed\Form\Concerns\Cancellable;
use Honed\Form\Concerns\HasAction;
use Honed\Form\Concerns\HasLib;
use Honed\Form\Concerns\HasSchema;
use Illuminate\Container\Container;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Throwable;

class Form extends Primitive implements NullsAsUndefined
{
    use Cancellable;
    use HasAction;
    use HasLib;
    use HasMethod;
    use HasSchema;

    /**
     * The source of the data to be used to populate the form.
     *
     * @var mixed
     */
    protected $from;

    /**
     * The identifier to use for evaluation.
     *
     * @var string
     */
    protected $evaluationIdentifier = 'form';

    /**
     * The default namespace where forms reside.
     */
    protected static string $namespace = 'App\\Forms\\';

    /**
     * How to resolve the form for the given model name.
     *
     * @var (Closure(class-string<\Illuminate\Database\Eloquent\Model>):class-string<Form>)|null
     */
    protected static $formNameResolver;

    /**
     * Provide the instance with any necessary setup.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->method(Request::METHOD_POST);
    }

    /**
     * Create a new form instance.
     *
     * @param  array<int, Abstracts\Component>  $schema
     */
    public static function make(array $schema = []): static
    {
        return resolve(static::class)->schema($schema);
    }

    /**
     * Get a new form instance for the given model name.
     *
     * @param  class-string<\Illuminate\Database\Eloquent\Model>  $modelName
     */
    public static function formForModel(string $modelName): self
    {
        $form = static::resolveFormName($modelName);

        return $form::make();
    }

    /**
     * Get the form name for the given model name.
     *
     * @param  class-string<\Illuminate\Database\Eloquent\Model>  $className
     * @return class-string<Form>
     */
    public static function resolveFormName(string $className): string
    {
        $resolver = static::$formNameResolver ?? function (string $className) {
            $appNamespace = static::appNamespace();

            $className = Str::startsWith($className, $appNamespace.'Models\\')
                ? Str::after($className, $appNamespace.'Models\\')
                : Str::after($className, $appNamespace);

            /** @var class-string<Form> */
            return static::$namespace.$className.'Form';
        };

        return $resolver($className);
    }

    /**
     * Specify the default namespace that contains the application's forms.
     */
    public static function useNamespace(string $namespace): void
    {
        static::$namespace = $namespace;
    }

    /**
     * Specify the callback that should be invoked to guess the name of a model form.
     *
     * @param  Closure(class-string<\Illuminate\Database\Eloquent\Model>):class-string<Form>  $callback
     */
    public static function guessFormNamesUsing(Closure $callback): void
    {
        static::$formNameResolver = $callback;
    }

    /**
     * Flush the global configuration state.
     */
    public static function flushState(): void
    {
        static::$namespace = 'App\\Forms\\';
        static::$formNameResolver = null;
    }

    /**
     * Set the data to be used to populate the form.
     *
     * @return $this
     */
    public function from(mixed $from): static
    {
        $this->from = $from;

        return $this;
    }

    /**
     * Get the application namespace for the application.
     */
    protected static function appNamespace(): string
    {
        try {
            return Container::getInstance()
                ->make(Application::class)
                ->getNamespace();
        } catch (Throwable) {
            return 'App\\';
        }
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
