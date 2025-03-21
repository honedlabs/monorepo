<?php

declare(strict_types=1);

namespace Honed\Refine;

class TextFilter extends Filter
{
    /**
     * {@inheritdoc}
     */
    public function setUp()
    {
        parent::setUp();
        $this->operator('like');
        $this->text();
    }
}
