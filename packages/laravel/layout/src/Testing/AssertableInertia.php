<?php

declare(strict_types=1);

namespace Honed\Layout\Testing;

use Honed\Layout\Response;
use Illuminate\Support\Arr;
use Illuminate\Testing\TestResponse;
use Inertia\Testing\AssertableInertia as InertiaAssert;
use PHPUnit\Framework\Assert as PHPUnit;

use function json_decode;
use function json_encode;

class AssertableInertia extends InertiaAssert
{
    /**
     * The layout of the Inertia page.
     *
     * @var string|array<int,string>|null
     * */
    protected $layout;

    /**
     * Change the visibility of the component.
     *
     * @var string
     */
    protected $component;

    /**
     * Create an assertable inertia instance from a test response.
     *
     * @param  TestResponse<\Symfony\Component\HttpFoundation\Response>  $response
     */
    public static function fromTestResponse(TestResponse $response): self
    {
        /** @var AssertableInertia */
        $instance = parent::fromTestResponse($response); // @phpstan-ignore-line

        // @phpstan-ignore-next-line
        $page = json_decode(json_encode($response->viewData('page')), true);

        /** @phpstan-ignore-next-line */
        [$component, $layout] = Response::parseComponent(Arr::get($page, 'component'));

        $instance->component = $component;
        $instance->layout = $layout;

        return $instance;
    }

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
}
