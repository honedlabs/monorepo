<?php

declare(strict_types=1);

use Honed\Layout\Response;
use Honed\Layout\Support\Parameters;
use Illuminate\Support\Facades\Request;

it('has layout for response', function () {
    $request = Request::create('/user/123', 'GET');

    $user = ['name' => 'Jonathan'];
    $response = (new Response('User/Edit', ['user' => $user], 'app', '123'));
    expect($response)
        ->getLayout()->toBeNull()
        ->layout('PageLayout')->toBe($response)
        ->getLayout()->toBe('PageLayout');

    /** @var \Illuminate\Http\Response $response */
    $response = $response->toResponse($request);

    expect($response->getOriginalContent()->getData()['page'])
        ->toBeArray()
        ->toHaveKey(Parameters::PROP)
        ->{Parameters::PROP}->toBe('PageLayout');
});

it('has layout for inertia response', function () {
    $request = Request::create('/user/123', 'GET');
    $request->headers->set('X-Inertia', 'true');

    $user = ['name' => 'Jonathan'];
    $response = (new Response('User/Edit', ['user' => $user], 'app', '123'))
        ->layout('PageLayout');

    /** @var \Illuminate\Http\Response $response */
    $page = $response->toResponse($request);

    expect($page->getData())
        ->toBeObject()
        ->toHaveProperty(Parameters::PROP)
        ->{Parameters::PROP}->toBe('PageLayout');
});
