import Render from "./component";
import { resolve } from "./resolver";
import { router } from "@inertiajs/vue3";
import { getComponent, getComponents } from "./utils";
import { h, type VNode } from "vue";
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
		Render: (errors: Record<string, string> = {}): VNode =>
			h(Render, { form, errors }),
	};
}
