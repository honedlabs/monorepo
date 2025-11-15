<?php

declare(strict_types=1);

namespace Honed\Scaffold\Console\View\Components;

use Symfony\Component\Console\Output\OutputInterface;
use Illuminate\Console\View\Components\Component;
use Illuminate\Console\View\Components\Line;

class Stage extends Line
{
    /**
     * Renders the component using the given arguments.
     * 
     * @param string $style
     * @param string $string
     * @param int $verbosity
     * @return void
     */
    public function render($style, $string, $verbosity = OutputInterface::VERBOSITY_NORMAL)
    {
        $this->addStyle();

        parent::render($style, $string, $verbosity);
    }

    protected function addStyle(): void
    {
        // static::$styles['stage'] = [
        //     ''
        // ]
    }
}
