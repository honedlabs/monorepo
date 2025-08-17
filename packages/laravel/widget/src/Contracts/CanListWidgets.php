<?php

namespace Honed\Widget\Contracts;

interface CanListWidgets
{
    /**
     * Get all the widgets stored.
     *
     * @return array<int, object>
     */
    public function all(): array;

    /**
     * Get the widgets stored for a given scope or scopes.
     *
     * @param  mixed|array<int, mixed>  $scopes
     * @return array<int, object>
     */
    public function stored(mixed $scopes): array;
}