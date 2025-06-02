<?php

declare(strict_types=1);

namespace Workbench\App\Models;

use Honed\Action\Attributes\ActionGroup;
use Honed\Action\Concerns\HasActionGroup;
use Honed\Refine\Attributes\Refiner;
use Honed\Refine\Concerns\HasRefiner;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Workbench\App\ActionGroups\UserActions;
use Workbench\Database\Factories\UserFactory;

// #[Refiner(UserRefiner::class)]
class User extends Authenticatable
{
    /**
     * @use \Honed\Refine\Concerns\HasRefiner<\Workbench\App\Refiners\UserRefiner>
     */
    use HasRefiner;

    /**
     * @use \Illuminate\Database\Eloquent\Factories\HasFactory<\Workbench\Database\Factories\UserFactory>
     */
    use HasFactory;

    use Notifiable;

    /**
     * The factory for the model.
     *
     * @return class-string<\Illuminate\Database\Eloquent\Factories\Factory>
     */
    protected static $factory = UserFactory::class;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
}
