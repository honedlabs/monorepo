<?php

declare(strict_types=1);

namespace Honed\Nav\Facades;

use Honed\Nav\Nav as NavNav;
use Illuminate\Support\Facades\Facade;

/**
 * 
 * @method static \Honed\Nav\Nav make(string $group, array<int,\Honed\Nav\NavItem>|\Honed\Nav\NavItem ...$items) Configure a new navigation group
 * @method static \Honed\Nav\Nav add(string $group, array<int,\Honed\Nav\NavItem>|\Honed\Nav\NavItem ...$items) Append a navigation item to the provided group
 * @method static array<string, array<int,\Honed\Nav\NavItem|\Honed\Nav\NavGroup>> get(array<int,string>|array{int,string}|array<int,array<int,string>> ...$groups) Retrieve the navigation items associated with the provided group(s)
 * @method static \Honed\Nav\NavGroup group(string $group) Retrieve the navigation items associated with the provided group
 * @method static bool hasGroups(array<int,string> ...$groups) Determine if the provided group(s) have navigation defined
 * @method static \Honed\Nav\Nav share(array<int,string> ...$groups) Share the navigation items via Inertia
 * 
 * @see \Honed\Nav\Nav
 */
class Nav extends Facade
{
    const ShareProp = NavNav::ShareProp;

    protected static function getFacadeAccessor(): string
    {
        return NavNav::class;
    }
}
