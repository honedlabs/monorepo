<?php

declare(strict_types=1);

namespace Honed\Form\Generators;

use Closure;
use Honed\Form\Exceptions\CannotResolveComponent;
use Honed\Form\Form;

/**
 * @extends Generator<\Illuminate\Http\Request>
 */
class RequestGenerator extends Generator
{
    /**
     * Generate a form.
     *
     * @throws CannotResolveComponent
     */
    public function generate(mixed ...$payloads): Form
    {
        $rules = $this->getRules();

        $adapters = $this->getAdapters();

        $form = $this->getForm();

        foreach ($rules as $key => $rule) {
            if (is_string($rule)) {
                $rule = explode('|', $rule);
            }

            $component = null;

            foreach ($adapters as $adapter) {
                if ($component = $adapter->getRulesComponent($key, $rule)) {
                    break;
                }
            }

            if ($component === null) {
                CannotResolveComponent::throw($key);
            }

            $form->append($component);
        }

        /** @var \Illuminate\Database\Eloquent\Model|null */
        $record = $payloads[0] ?? null;

        $form->record($record);

        return $form;
    }

    /**
     * Get the rules for the request.
     *
     * @return array<string, string|list<string|Closure|\Illuminate\Validation\Rule>>
     */
    public function getRules(): array
    {
        // Create request outside of the container to ensure it does not execute
        // the validation rules.
        $request = new $this->for();

        if (method_exists($request, 'rules')) {
            /** @var array<string, string|list<string|Closure|\Illuminate\Validation\Rule>> */
            return $request->rules();
        }

        return [];
    }
}
