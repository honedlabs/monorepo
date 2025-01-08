<?php

declare(strict_types=1);

namespace Honed\Action;

class Creator
{
    const Bulk = 'bulk';
    const Inline = 'inline';
    const Page = 'page';

    /**
     * Create a new action.
     * 
     * @param string $type
     * @param string $name
     * @param string|\Closure $label
     * @return \Honed\Action\Action
     */
    public function new($type, $name, $label = null)
    {
        return match ($type) {
            self::Bulk => $this->bulk($name, $label),
            self::Inline => $this->inline($name, $label),
            self::Page => $this->page($name, $label),
            default => throw new InvalidActionTypeException($type)
        };
    }

    /**
     * Create a new bulk action.
     * 
     * @param string $name
     * @param string|\Closure $label
     * @return \Honed\Action\Action
     */
    public function bulk($name, $label = null)
    {
        return $this->new(self::Bulk, $name, $label);
    }

    /**
     * Create a new inline action.
     * 
     * @param string $name
     * @param string|\Closure $label
     * @return \Honed\Action\Action
     */
    public function inline($name, $label = null)
    {
        return $this->new(self::Inline, $name, $label);
    }

    /**
     * Create a new page action.
     * 
     * @param string $name
     * @param string|\Closure $label
     * @return \Honed\Action\Action
     */
    public function page($name, $label = null)
    {
        return $this->new(self::Page, $name, $label);
    }
}