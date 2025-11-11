import R from "./component";
import { resolve } from "./resolver";
import { router, type InertiaForm } from "@inertiajs/vue3";
import { getComponent, getComponents } from "./utils";
import { defineComponent, h, type PropType } from "vue";
import type { Form } from "./types";

export function useComponents<TForm extends Record<string, string> = Record<string, string>>(form: Form, helper?: InertiaForm<TForm>) {
	function onCancel(reset?: () => void) {
		if (form.cancel === "reset") {
			reset?.()
			helper?.reset();
		}
		else if (form.cancel !== undefined) 
			router.visit(form.cancel);
		else {
			helper?.cancel();
			reset?.();
		}
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
