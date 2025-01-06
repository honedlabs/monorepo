<?php

declare(strict_types=1);

use function Pest\Laravel\get;
use Honed\Table\Columns\Column;
use Honed\Table\Concerns\Toggleable;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Request;
use Symfony\Component\HttpFoundation\Request as HttpFoundationRequest;

class ToggleableTest
{
    use Toggleable;
}

class ToggleablePropertyTest extends ToggleableTest
{
    public $cookies = false;

    public $cookie = 'example';

    public $duration = 10;

    public $remember = 'example';

    public $toggle = true;
}

beforeEach(function () {
    ToggleableTest::alwaysToggleable(false);
    ToggleableTest::rememberCookieAs(ToggleableTest::RememberName);
    ToggleableTest::rememberCookieFor(ToggleableTest::RememberDuration);
    ToggleableTest::useCookies();
    $this->test = new ToggleableTest;
    $this->property = new ToggleablePropertyTest;
    $this->data = ['name', 'public_id', 'description'];
});

it('configures to use cookies by default', function () {
    ToggleableTest::useCookies(true);
    expect($this->test)
        ->useCookie()->toBeTrue();
});

it('configures a remember name', function () {
    ToggleableTest::rememberCookieAs('example');
    expect($this->test)
        ->getRememberName()->toBe('example');
});

it('configures a cookie duration', function () {
    ToggleableTest::rememberCookieFor(10);
    expect($this->test)
        ->getRememberDuration()->toBe(10);
});

it('configures as always toggleable', function () {
    ToggleableTest::alwaysToggleable(true);
    expect($this->test)
        ->isToggleable()->toBeTrue();
});

it('is not `toggleable` by default', function () {
    expect($this->test)
        ->isToggleable()->toBeFalse();
});

it('sets toggleable', function () {
    $this->test->setToggleable(true);
    expect($this->test)
        ->isToggleable()->toBeTrue();
});

it('retrieves query parameter name', function () {
    expect($this->test)
        ->getRememberName()->toBe(ToggleableTest::RememberName);

    expect($this->property)
        ->getRememberName()->toBe('example');
});

it('retrieves cookie duration', function () {
    expect($this->test)
        ->getRememberDuration()->toBe(ToggleableTest::RememberDuration);

    expect($this->property)
        ->getRememberDuration()->toBe(10);
});

it('retrieves cookie name', function () {
    expect($this->test)
        ->getCookieName()->toBe('toggleable-test-table');

    expect($this->property)
        ->getCookieName()->toBe('example');
});

it('retrieves whether to use cookies', function () {
    expect($this->test)
        ->useCookie()->toBeTrue();

    expect($this->property)
        ->useCookie()->toBeFalse();
});

it('enqueues a cookie', function () {
    $this->test->enqueueCookie($this->data);
    expect(Cookie::getQueuedCookies())
        ->toHaveCount(1)
        ->{0}->scoped(fn ($cookie) => $cookie
            ->getName()->toBe($this->test->getCookieName())
            ->getValue()->toBe(\json_encode($this->data))
        );
});

it('retrieves a cookie', function () {
    $this->test->enqueueCookie($this->data);

    $response = get('/');
    
    expect($response->getCookie($this->test->getCookieName()))
        ->not->toBeNull()
        ->getValue()->toBe(\json_encode($this->data));

    $request = Request::create('/');
    $request->cookies->set(
        $this->test->getCookieName(), 
        \json_encode($this->data)
    );

    expect($this->test->retrieveCookie($request))
        ->toBe($this->data);
});

it('retrieves toggle parameters', function () {
    $request = Request::create('/', HttpFoundationRequest::METHOD_GET, [
        ToggleableTest::RememberName => 'name,public_id,description',
    ]);
    expect($this->test->toggleParameters($request))
        ->toBe($this->data);
});

it('retrirves empty toggle parameters', function () {

    expect($this->test->toggleParameters())
        ->toBeNull();
});

describe('toggling', function () {
    beforeEach(function () {
        $this->columns = collect([
            Column::make('name'),
            Column::make('price'),
        ]);
    });

    it('toggles columns', function () {
        $request = Request::create('/', HttpFoundationRequest::METHOD_GET, [
            $this->property->getRememberName() => 'name,price,misc',
        ]);

        $this->property->toggleColumns($this->columns, $request);
    });

    it('fallbacks to using cookie', function () {
        $this->property->toggleColumns($this->columns);
    });
});
