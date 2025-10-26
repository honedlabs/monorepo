<?php

declare(strict_types=1);

namespace Honed\Data\Rules;

use Illuminate\Contracts\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Auth;
use Intervention\Validation\AbstractRule;

class Authorized extends AbstractRule
{
    /**
     * @param  class-string<\Illuminate\Database\Eloquent\Model>  $className
     */
    public function __construct(
        protected string $ability,
        protected string $className,
        protected ?string $column = null,
        protected ?string $guard = null,
    ) {}

    /**
     * Check if the given value is valid in the scope of the current rule.
     */
    public function isValid(mixed $value): bool
    {
        if (! $user = $this->getUser()) {
            return false;
        }

        $model = $this->column
            ? resolve($this->className)->resolveRouteBinding($value, $this->column)
            : $this->className;

        if (! $model) {
            return false;
        }

        return $user->can($this->ability, $model);
    }

    /**
     * Return the shortname of the current rule.
     */
    protected function shortname(): string
    {
        return 'authorized';
    }

    /**
     * Get the currently authenticated user.
     */
    protected function getUser(): (Authenticatable&Authorizable)|null
    {
        /** @var (Authenticatable&Authorizable)|null */
        return Auth::guard($this->guard)->user();
    }
}
