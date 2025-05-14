<?php

declare(strict_types=1);

namespace Honed\Widget\Contracts;

interface Driver
{
    public function get(string $widget, string $scope): mixed;

    public function set(string $widget, string $scope, mixed $value): void;

    public function delete(string $widget, string $scope): void;   
}