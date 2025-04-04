<?php

declare(strict_types=1);

namespace Honed\Static;

class StaticRouter
{
    protected $except;

    public function routes()
    {

    }

    public function hasLayout()
    {
        // return \class_exists(\Honed\Layout\Response::class);
    }
}