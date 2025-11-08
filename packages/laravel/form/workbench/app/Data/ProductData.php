<?php

declare(strict_types=1);

namespace App\Data;

use Honed\Data\Attributes\ArrayParameter;
use Honed\Form\Attributes\Component;
use Honed\Form\Components\Checkbox;
use Honed\Form\Components\Lookup;
use Honed\Form\Concerns\GeneratesForm;
use Honed\Form\Support\Trans;
use Honed\Form\Support\Url;
use Spatie\LaravelData\Attributes\LoadRelation;
use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\Min;
use Spatie\LaravelData\Data;

class ProductData extends Data
{
    use GeneratesForm;

    #[ArrayParameter('id')]
    #[LoadRelation]
    #[Component(Lookup::class, label: new Trans('User'), url: new Url('users.index'))]
    public UserData $user;

    #[Min(2), Max(255)]
    public string $name;

    #[Max(65535)]
    public string $description;

    #[Min(0), Max(999)]
    public int $price;

    #[Component(Checkbox::class, default: true)]
    public bool $best_seller;

    /**
     * @var list<int, UserData>
     */
    public array $users;
}
