<?php

declare(strict_types=1);

namespace Honed\Form;

use Closure;
use Honed\Core\Primitive;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Honed\Form\Concerns\HasLib;
use Honed\Core\Concerns\HasMethod;
use Honed\Form\Concerns\HasAction;
use Honed\Form\Concerns\HasSchema;
use Honed\Form\Concerns\Cancellable;
use Honed\Core\Contracts\NullsAsUndefined;
use Illuminate\Container\Container;
use Illuminate\Contracts\Foundation\Application;
use Throwable;

class Form extends Primitive implements NullsAsUndefined
{
    use Cancellable;
    use HasAction;
    use HasLib;
    use HasMethod;
    use HasSchema;

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
     * @var (Closure(class-string<\Illuminate\Database\Eloquent\Model>):class-string<\Honed\Form\Form>)|null
     */
    protected static $formNameResolver;

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
     * Get a new form instance for the given model name.
     *
     * @template TClass of \Illuminate\Database\Eloquent\Model
     *
     * @param  class-string<TClass>  $modelName
     * @return Form<TClass>
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
     * @return class-string<\Honed\Form\Form>
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
     * @param  Closure(class-string<\Illuminate\Database\Eloquent\Model>):class-string<\Honed\Form\Form>  $callback
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
