<?php

declare(strict_types=1);

namespace Honed\Layout\Testing;

use Illuminate\Support\Arr;
use Illuminate\Testing\TestResponse;
use Inertia\Testing\AssertableInertia as InertiaAssert;
use PHPUnit\Framework\Assert as PHPUnit;

class AssertableInertia extends InertiaAssert
{
    /**
     * The layout of the Inertia page.
     *
     * @var string|array<int,string>|null
     * */
    private $layout;

    /**
     * Determine if the layout is the expected layout.
     *
     * @param  string|array<int,string>|null  $layout
     * @return $this
     */
    public function layout($layout = null)
    {
        PHPUnit::assertSame($layout, $this->layout, 'Unexpected Inertia page layout.');

        return $this;
    }

    /**
     * Create an assertable inertia instance from a test response.
     *
     * @param  \Illuminate\Testing\TestResponse<\Symfony\Component\HttpFoundation\Response>  $response
     */
    public static function fromTestResponse(TestResponse $response): self
    {
        /** @var \Honed\Layout\Testing\AssertableInertia */
        $instance = parent::fromTestResponse($response);

        // @phpstan-ignore-next-line
        $page = \json_decode(\json_encode($response->viewData('page')), true);

        // @phpstan-ignore-next-line
        $instance->layout = Arr::get($page, 'layout', null);

        return $instance;
    }
}
