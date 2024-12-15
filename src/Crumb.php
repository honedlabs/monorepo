<?php

namespace Honed\Crumb;

use Honed\Core\Concerns\HasName;
use Honed\Core\Primitive;

class Crumb extends Primitive
{
    use HasName;

    public function __construct(
        public string|\Closure $name,
        public string $url = null,
    ) {}

    public static function make(string|\Closure $name, string $url = null)
    {
        return new static($name, $url);
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'url' => $this->url,
        ];
    }
}
