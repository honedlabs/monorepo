<?php

declare(strict_types=1);

namespace Tests\Feature\Casts;

use App\Models\User;
use Honed\Widget\Casts\WidgetCast;
use Honed\Widget\Facades\Widgets;

beforeEach(function () {
    $this->cast = new WidgetCast();
});

