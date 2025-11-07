<?php

declare(strict_types=1);

namespace App\Data;

use Spatie\LaravelData\Data;
use Honed\Form\Components\Lookup;
use Honed\Form\Components\Checkbox;
use Honed\Form\Attributes\Component;
use Honed\Form\Form;
use Spatie\LaravelData\Support\DataConfig;
use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\Min;
use Spatie\LaravelData\Support\DataAttributesCollection;

class ProductData extends Data
{
    #[Component(Lookup::class)]
    public int $user_id;

    #[Min(2), Max(255)]
    public string $name;

    #[Max(65535)]
    public string $description;

    #[Min(0), Max(999)]
    public int $price;

    #[Component(Checkbox::class)]
    public bool $best_seller;

    public static function form()
    {
        // return static::newForm()
        dd(
            app(DataConfig::class)
            ->getDataClass(static::class)
        );

        DataAttributesCollection::class;
    }

    /**
     * Create a new form instance.
     */
    protected static function getComponents()
    {
        return Service::transform(static::class);
    }
}