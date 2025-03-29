<?php

declare(strict_types=1);

namespace Honed\Layout\Testing;

use Illuminate\Testing\TestResponse;
use Inertia\Testing\AssertableInertia as InertiaAssert;
use PHPUnit\Framework\Assert as PHPUnit;

class AssertableInertia extends InertiaAssert
{
    /** 
     * The layout of the Inertia page.
     * 
     * @var string|null 
     * */
    private $layout;

    /**
     * Determine if the layout is the expected layout.
     * 
     * @param  string|null  $layout
     */
    public function layout($layout = null)
    {
        PHPUnit::assertSame($layout, $this->layout, 'Unexpected Inertia page layout.');

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public static function fromTestResponse(TestResponse $response): self
    {
        /** @var \Honed\Layout\Testing\AssertableInertia */
        $instance = parent::fromTestResponse($response);

        $page = \json_decode(\json_encode($response->viewData('page')), true);

        $instance->layout = $page['layout'];

        return $instance;
    }
}