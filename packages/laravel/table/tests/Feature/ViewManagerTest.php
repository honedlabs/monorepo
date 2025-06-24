<?php

declare(strict_types=1);

use Honed\Table\ViewManager;
use Illuminate\Support\Facades\App;

beforeEach(function () {
    $this->manager = App::make(ViewManager::class);
});

