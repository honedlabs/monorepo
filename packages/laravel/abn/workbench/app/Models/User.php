<?php

declare(strict_types=1);

namespace Workbench\App\Models;

use Honed\Abn\Casts\FormatAbn;
use Honed\Abn\Casts\FormattedAbn;
use Honed\Action\Attributes\ActionGroup;
use Illuminate\Notifications\Notifiable;
use Honed\Action\Concerns\HasActionGroup;
use Workbench\App\ActionGroups\UserActions;
use Workbench\Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
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
        'abn',
        'formatted_abn',
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
        'abn' => FormattedAbn::class,
        'formatted_abn' => FormatAbn::class,
    ];
}
