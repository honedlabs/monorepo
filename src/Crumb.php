<?php

declare(strict_types=1);

namespace Honed\Crumb;

use Honed\Core\Primitive;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;

/**
 * @method array toArray(array $named = [], array $typed = [])
 */
class Crumb extends Primitive
{
    use \Honed\Core\Concerns\HasName;
    use \Honed\Core\Concerns\HasMeta;
    use Concerns\HasIcon;
    use Concerns\HasLink;
    use Concerns\ClosureParameters;

    /**
     * Create a new crumb instance.
     * 
     * @param string|(\Closure(mixed...):string) $name
     * @param string|(\Closure(mixed...):string)|null $link
     * @param string|null $icon
     */
    public function __construct(
        string|\Closure $name,
        string|\Closure $link = null,
        string $icon = null,
    ) {
        $this->setName($name);
        $this->setLink($link);
        $this->setIcon($icon);
    }

    /**
     * Make a new crumb instance.
     * 
     * @param string|(\Closure(mixed...):string) $name
     * @param string|(\Closure(mixed...):string)|null $link
     * @param string|null $icon
     * @return $this
     */
    public static function make(string|\Closure $name, string|\Closure $link = null, string $icon = null): static
    {
        return resolve(static::class, compact('name', 'link', 'icon'));
    }

    /**
     * Get the crumb as an array
     * 
     * @return non-empty-array<'name'|'url'|'icon',string|null>
     */
    public function toArray(): array
    {
        [$named, $typed] = $this->getClosureParameters();
        
        return [
            'name' => $this->getName($named, $typed),
            'url' => $this->getLink($named, $typed),
            ...($this->hasIcon() ? ['icon' => $this->getIcon()] : []),
        ];
    }

    public function isCurrent(): bool
    {
        [$named, $typed] = $this->getClosureParameters();

        $this->link = $this->getLink($named, $typed);

        return (bool) $this->link ? Request::url() === url($this->link) : false;
    }
}
