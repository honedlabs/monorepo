<?php

namespace Honed\Widget\Concerns;

use Honed\Widget\Attributes\Widgets as WidgetsAttribute;
use Honed\Widget\Facades\Widgets;
use Illuminate\Support\Arr;

trait HasWidgets
{
    /**
     * Get the widgets active for the class.
     * 
     * @param string|null $driver
     * @return array<int, \Honed\Widget\Widget>
     */
    public function widgets($driver = null)
    {
        $widgets = [
            ...Widgets::driver($driver)->for($this),
            ...$this->getWidgets(),
            ...$this->getWidgetsAttribute(),
        ];

        return $this->createWidgets($widgets);
    }

    /**
     * Define the default widgets for the class, which will not be
     * stored by the driver.
     * 
     * @return array<int, class-string<\Honed\Widget\Widget>>
     */
    public function getWidgets()
    {
        return [];
    }

    /**
     * Get the cache from the Cache class attribute.
     *
     * @return array<int, class-string<\Honed\Widget\Widget>>
     */
    protected static function getWidgetsAttribute()
    {
        $attributes = (new \ReflectionClass(static::class))
            ->getAttributes(Widgets::class);

        if ($attributes !== []) {
            $widgets = $attributes[0]->newInstance();

            return Arr::wrap($widgets->widgets);
        }

        return [];
    }

    /**
     * Create the widgets from the given array.
     * 
     * @param array<int, class-string<\Honed\Widget\Widget>> $widgets
     * @return array<int, \Honed\Widget\Widget>
     */
    protected function createWidgets($widgets)
    {
        return array_map(static fn ($widget) => new $widget, $widgets);
    }
}