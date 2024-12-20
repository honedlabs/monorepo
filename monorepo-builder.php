<?php

declare(strict_types=1);

use Symplify\MonorepoBuilder\Config\MBConfig;

return static function (MBConfig $mbConfig): void {
    $mbConfig->packageDirectories([__DIR__ . '/packages/laravel']);
    $mbConfig->packageAliasFormat('<major>.<minor>.x-dev');
};
