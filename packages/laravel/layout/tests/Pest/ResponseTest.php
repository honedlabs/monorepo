<?php

declare(strict_types=1);

use Honed\Layout\Response;
use Illuminate\Support\Facades\Request;
use Inertia\Support\Header;

enum BackedLayout: string
{
    case PAGE = 'PageLayout';
}

enum UnitLayout
{
    case PageLayout;
}

beforeEach(function () {
    $this->response = (new Response('User/Edit', ['user' => ['name' => 'Jonathan']], 'app', '123'))
        ->layout('PageLayout');
});

it('has layout for backed enum', function () {
    expect($this->response)
        ->layout(BackedLayout::PAGE)->toBe($this->response)
        ->getLayout()->toBe('PageLayout');
});

it('has layout for unit enum', function () {
    expect($this->response)
        ->layout(UnitLayout::PageLayout)->toBe($this->response)
        ->getLayout()->toBe('PageLayout');
});

it('has layouted response', function () {
    expect($this->response)
        ->getLayout()->toBe('PageLayout')
        ->getLayoutedComponent()->toBe('User/Edit'.Response::FORMATTER.'PageLayout');

    expect(new Response('User/Edit', ['user' => ['name' => 'Jonathan']], 'app', '123'))
        ->getLayout()->toBeNull()
        ->getLayoutedComponent()->toBe('User/Edit');
});

it('checks partial with layout', function () {
    $request = Request::create('/user/123', 'GET');

    expect($this->response)
        ->isPartial($request)->toBeFalse();

    $request->headers->set(Header::PARTIAL_COMPONENT, 'User/Edit'.Response::FORMATTER.'PageLayout');

    expect($this->response)
        ->isPartial($request)->toBeTrue();
});

it('has layout for response', function () {
    $request = Request::create('/user/123', 'GET');

    expect($this->response)
        ->layout('PageLayout')->toBe($this->response)
        ->getLayout()->toBe('PageLayout');

    /** @var \Illuminate\Http\Response $response */
    $response = $this->response->toResponse($request);

    expect($response->getOriginalContent()->getData()['page'])
        ->toBeArray()
        ->toHaveKey('component')
        ->component->toBe('User/Edit'.Response::FORMATTER.'PageLayout');
});

it('has layout for inertia response', function () {
    $request = Request::create('/user/123', 'GET');

    $request->headers->set(Header::INERTIA, 'true');

    /** @var \Illuminate\Http\Response $response */
    $page = $this->response->toResponse($request);

    expect($page->getData())
        ->toBeObject()
        ->toHaveProperty('component')
        ->component->toBe('User/Edit'.Response::FORMATTER.'PageLayout');
});
