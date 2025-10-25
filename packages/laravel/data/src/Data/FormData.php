<?php

declare(strict_types=1);

namespace Honed\Data\Data;

use Honed\Data\Concerns\FormsData;
use Honed\Data\Contracts\Formable;
use Spatie\LaravelData\Data;

class FormData extends Data implements Formable
{
    use FormsData;
}
