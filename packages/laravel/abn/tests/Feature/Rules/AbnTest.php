<?php

declare(strict_types=1);

use function Pest\Laravel\post;

it('passes valid ABN', function () {
    $abn = '51 824 753 556';

    post(route('users.store'), [
        'abn' => $abn,
        'formatted_abn' => $abn,
    ])->assertSessionHasNoErrors();
});

it('fails invalid ABN', function () {
    $abn = '01 824 753 556';

    post(route('users.store'), [
        'abn' => $abn,
        'formatted_abn' => $abn,
    ])->assertSessionHasErrors('abn');
});
