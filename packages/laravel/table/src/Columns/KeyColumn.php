<?php

declare(strict_types=1);

namespace Honed\Table\Columns;

class KeyColumn extends Column
{
    /**
     * {@inheritdoc}
     */
    protected $key = true;

    /**
     * {@inheritdoc}
     */
    protected $hidden = true;

    /**
     * {@inheritdoc}
     */
    public function defineType()
    {
        return 'key';
    }
}
