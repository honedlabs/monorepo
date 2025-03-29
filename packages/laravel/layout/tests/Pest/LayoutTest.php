<?php

declare(strict_types=1);

use function Pest\Laravel\get;

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

    $page = $response->toResponse($request)
        ->getOriginalContent()
        ->getData();

    expect($page['page'])
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

    $page = $response->toResponse($request)
        ->getData();

    expect($page)
        ->toBeObject()
        ->toHaveProperty(Parameters::PROP)
        ->{Parameters::PROP}->toBe('PageLayout');
});

