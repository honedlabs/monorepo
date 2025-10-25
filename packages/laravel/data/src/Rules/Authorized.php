<?php

// declare(strict_types=1);

// namespace Honed\Data\Rules;

// use Illuminate\Support\Facades\Auth;
// use Intervention\Validation\AbstractRule;

// class Authorized extends AbstractRule
// {
//     /**
//      * @param class-string<\Illuminate\Database\Eloquent\Model> $className
//      */
//     public function __construct(
//         protected string $ability,
//         protected string $className,
//         protected ?string $guard = null,
//         protected ?string $column = null,
//     ) {}

//     public function isValid(mixed $value): bool
//     {
//         if (! $user = Auth::guard($this->guard)->user()) {
//             return false;
//         }

//         if ($this->column && ! $model = resolve($this->className)->resolveRouteBinding($value, $this->column)) {
//             return false;
//         }

//         return $user->can($this->ability, $model);
//     }
//     /**
//      * Return the shortname of the current rule.
//      */
//     protected function shortname(): string
//     {
//         return 'authorized';
//     }

// }