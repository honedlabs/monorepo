<?php

namespace Honed\Core\Contracts;

interface ResolvesClosures
{
    public function resolve($namedOrModel = [], $typed = []);
}
