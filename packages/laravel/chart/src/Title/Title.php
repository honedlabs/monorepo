<?php

declare(strict_types=1);

namespace Honed\Chart\Title;

use Honed\Chart\Concerns\CanBeShown;
use Honed\Chart\Concerns\HasId;
use Honed\Chart\Title\Concerns\HasText;
use Honed\Core\Concerns\CanHaveUrl;
use Honed\Core\Primitive;

class Title extends Primitive
{
    use HasId;
    use CanBeShown;
    use CanHaveUrl;
    use HasText;

    protected function representation(): array
    {
        return [
            'id' => $this->getId(),
            'show' => $this->isShown(),
            'text' => $this->getText(),
            'link' => $this->getUrl(),
            'textStyle' => $this->getTextStyle()?->toArray(),
        ];
    }
}