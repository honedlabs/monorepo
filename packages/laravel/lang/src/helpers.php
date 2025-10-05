<?php

declare(strict_types=1);

use Honed\Lang\Facades\Lang;
use Honed\Lang\LangManager;

if (! function_exists('lang')) {

    /**
     * Lang helper.
     */
    function lang(string ...$files): LangManager
    {
        $instance = Lang::getFacadeRoot();

        if (! empty($files)) {
            return $instance->use(...$files);
        }

        return $instance;
    }
}
