<?php

declare(strict_types=1);

use Honed\Core\Concerns\Evaluable;
use Honed\Core\Concerns\EvaluableDependency;
use Honed\Core\Concerns\HasDescription;
use Honed\Core\Concerns\HasName;

class EvaluableDependencyTest
{
    use HasName;
    use HasDescription;
    use Evaluable;
    use EvaluableDependency;
}

beforeEach(function () {
    $this->test = new EvaluableDependencyTest;
});

it('evaluates', function () {
})->todo();
