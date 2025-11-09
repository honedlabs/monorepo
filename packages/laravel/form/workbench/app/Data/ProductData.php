<?php

declare(strict_types=1);

namespace App\Data;

use App\Enums\Status;
use Honed\Data\Attributes\ArrayParameter;
use Honed\Form\Attributes\Component;
use Honed\Form\Components\Lookup;
use Honed\Form\Concerns\GeneratesForm;
use Honed\Form\Support\Route;
use Honed\Form\Support\Trans;
use Spatie\LaravelData\Attributes\Computed;
use Spatie\LaravelData\Attributes\FromAuthenticatedUserProperty;
use Spatie\LaravelData\Attributes\LoadRelation;
use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\Min;
use Spatie\LaravelData\Data;

class ProductData extends Data
{
    use GeneratesForm;

    #[Computed]
    public $computed;

    #[ArrayParameter('id')]
    #[Component(Lookup::class, label: new Trans('User'), url: new Route('users.index'))]
    public ?UserData $user;

    #[Min(2), Max(255)]
    public string $name;

    #[Max(65535)]
    public ?string $description;

    #[Min(0), Max(999)]
    public int $price;

    public bool $best_seller;

    public Status $status = Status::Available;

    /**
     * @var list<int, UserData>
     */
    #[LoadRelation]
    public array $users;

    #[FromAuthenticatedUserProperty(property: 'id')]
    public ?int $created_by;

    protected $hidden;
}
