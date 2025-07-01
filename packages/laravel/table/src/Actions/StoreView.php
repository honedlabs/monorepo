<?php

declare(strict_types=1);

namespace Honed\Table\Actions;

use Honed\Action\Contracts\Action;
use Honed\Table\Facades\Views;
use Honed\Table\Table;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class StoreView extends ViewAction
{
    /**
     * Store a new view.
     *
     * @return object
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function handle(
        Table $table,
        Request $request,
        string $field = 'name',
        mixed $scope = null
    ): void {
        if ($table->isNotViewable()) {
            $this->fail($field, 'We were unable to store the view.');
        }

        try {
            $name = $this->getName($request, $field);

            $view = $this->state($table, $request);

            $this->store($table, $scope, $name, $view);
            
        } catch (UniqueConstraintViolationException $e) {
            $this->fail($field, 'The view name must be unique.');
        }
    }

    /**
     * Store a view.
     *
     * @param \Honed\Table\Table $table
     * @param mixed $scope
     * @param string $name
     * @param array<string, mixed> $view
     * @return void
     */
    protected function store(Table $table, mixed $scope, string $name, array $view): void
    {
        Views::for($scope)->create($table, $name, $view);
    }
}
