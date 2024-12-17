<?php

declare(strict_types=1);

namespace Honed\Crumb;

class ManagerTrail extends Trail
{
    /**
     * @var bool
     */
    protected $lock = false;

    /**
     * Append crumbs to the end of the crumb trail.
     * 
     * @param string|\Honed\Crumb\Crumb|(\Closure(mixed...):string) $crumb
     * @param string|(\Closure(mixed...):string)|null $link
     * @param string|null $icon
     * @return $this
     */
    public function add(string|\Closure|Crumb $crumb, string|\Closure|null $link = null, string|null $icon = null): static
    {
        if ($this->lock) {
            return $this;
        }

        $this->crumbs[] = match (true) {
            $crumb instanceof Crumb => $crumb,
            default => Crumb::make($crumb, $link, $icon),
        };

        return $this;
    }

    // private function appendCrumb()

    public function handle()
    {
        [$named, $typed] = $this->getClosureParameters();

        // Check and resolve each route
    }
}