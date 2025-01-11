<?php

declare(strict_types=1);

namespace Honed\Action;

use Honed\Action\PageAction;
use Honed\Action\Exceptions\InvalidActionTypeException;

class Creator
{
    const Bulk = 'bulk';
    const Inline = 'inline';
    const Page = 'page';
    const Polymorphic = 'polymorphic';

    /**
     * Create a new action.
     */
    public function new(string $type, string $name, string|\Closure $label = null): Action
    {
        return match ($type) {
            self::Bulk => $this->bulk($name, $label),
            self::Inline => $this->inline($name, $label),
            self::Page => $this->page($name, $label),
            self::Polymorphic => $this->polymorphic($name, $label),
            default => throw new InvalidActionTypeException($type)
        };
    }

    /**
     * Create a new bulk action.
     */
    public function bulk(string $name, string|\Closure $label = null): BulkAction
    {
        return BulkAction::make($name, $label);
    }

    /**
     * Create a new inline action.
     */
    public function inline(string $name, string|\Closure $label = null): InlineAction
    {
        return InlineAction::make($name, $label);
    }

    /**
     * Create a new page action.
     */
    public function page(string $name, string|\Closure $label = null): PageAction
    {
        return PageAction::make($name, $label);
    }

    /**
     * Create a new polymorphic action.
     */
    public function polymorphic(string $name, string|\Closure $label = null): Action
    {
        return InlineAction::make($name, $label)->morph();
    }
}