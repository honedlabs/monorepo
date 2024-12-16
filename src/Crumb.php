<?php

namespace Honed\Crumb;

use Honed\Core\Primitive;

class Crumb extends Primitive
{
    use \Honed\Core\Concerns\HasName;
    use \Honed\Core\Concerns\HasMeta;
    use Concerns\HasIcon;
    use Concerns\HasLink;

    /**
     * @var string|(\Closure(mixed...):string)|null
     */
    protected $link;

    /**
     * Create a new crumb instance.
     * 
     * @param string|(\Closure(mixed...):string) $name
     * @param string|(\Closure(mixed...):string)|null $link
     * @param array<array-key, mixed> $meta
     */
    public function __construct(
        string|\Closure $name,
        string|\Closure $link = null,
        array $meta = [],
    ) {
        $this->setName($name);
        $this->setLink($link);
        $this->setMeta($meta);
    }

    /**
     * Create a new crumb instance.
     * 
     * @param string|(\Closure(mixed...):string) $name
     * @param string|(\Closure(mixed...):string)|null $link
     * @param array<array-key, mixed> $meta
     */
    public static function make(string|\Closure $name, string|\Closure $link = null, array $meta = [])
    {
        return resolve(static::class, compact('name', 'link', 'meta'));
    }

    /**
     * Get the crumb as an array
     *
     * @return non-empty-array<'name'|'url'|'icon',string|null>
     */
    public function toArray(): array
    {
        return [
            'name' => $this->getName([
                // ...$product
                // 'record'
                // 'page'
                // 'id'
            ], [
                // class-name
            ]),
            'url' => $this->getLink([

            ], [

            ]),
            ...($this->hasIcon() ? ['icon' => $this->getIcon()] : []),
        ];
    }
}
