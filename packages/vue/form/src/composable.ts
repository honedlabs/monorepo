import R from "./component";
import { resolve } from "./resolver";
import { router } from "@inertiajs/vue3";
import { getComponent, getComponents } from "./utils";
import { defineComponent, h, type PropType } from "vue";
import type { Form } from "./types";

export function useComponents(form: Form) {
	function onCancel(reset?: () => void) {
		if (form.cancel === "reset") reset?.();
		else if (form.cancel !== undefined) router.visit(form.cancel);
		else reset?.();
	}

	const Render = defineComponent({
		props: {
			errors: {
				type: Object as PropType<Record<string, string>>,
				default: () => ({}),
			},
		},
		setup(props) {
			return () => h(R, { form, errors: props.errors });
		},
	});

	return {
		resolve,
		getComponent,
		getComponents,
		onCancel,
		Render,
	};
}
