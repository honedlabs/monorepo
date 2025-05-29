<?php

declare(strict_types=1);

use Workbench\App\Models\User;
use Workbench\App\Repositories\UserRepository;

// it('resolves repository model', function () {
//     UserRepository::guessRepositoryNamesUsing(function ($class) {
//         return $class.'Repository';
//     });

//     expect(UserRepository::resolveRepositoryName(User::class))
//         ->toBe('Workbench\\App\\Models\\UserRepository');

//     expect(UserRepository::repositoryForModel(User::class))
//         ->toBeInstanceOf(UserRepository::class);

//     UserRepository::flushState();
// });

// it('uses namespace', function () {
//     UserRepository::useNamespace('');

//     expect(UserRepository::resolveRepositoryName(User::class))
//         ->toBe('Workbench\\App\\Models\\UserRepository');

//     UserRepository::flushState();
// });
