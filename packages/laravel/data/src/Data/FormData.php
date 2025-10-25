<?php

declare(strict_types=1);

namespace Honed\Data\Data;

use Honed\Data\Concerns\FormsData;
use Spatie\LaravelData\Data;
use Honed\Data\Contracts\Formable;

class FormData extends Data implements Formable
{
    use FormsData;
}
