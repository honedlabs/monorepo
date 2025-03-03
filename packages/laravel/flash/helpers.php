<?php

declare(strict_types=1);

if (!function_exists('flash')) {
    function flash($component = null, $props = [])
    {
        $instance = \Honed\Flash\Facades\Flash::getFacadeRoot();

        if ($component) {
            return $instance->render($component, $props);
        }

        return $instance;
    }
}