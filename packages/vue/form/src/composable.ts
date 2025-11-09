import { resolve } from "./resolver";
import { Render } from "./component";
import { router } from "@inertiajs/vue3";
import { getComponent, getComponents } from "./utils";
import type { Form } from "./types";

export function useComponents(form: Form) {
	function onCancel(reset?: () => void) {
		if (form.cancel === "reset") reset?.();
		else if (form.cancel !== undefined) router.visit(form.cancel);
	}

	return {
		resolve,
		getComponent,
		getComponents,
		onCancel,
		Render: (errors?: Record<string, string>) => Render({ form, errors }),
	};
}
