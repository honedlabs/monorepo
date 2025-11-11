import { h, defineComponent, type PropType } from "vue";
import { getComponents } from "./utils";
import type { Form } from "./types";

const FragmentWrapper = defineComponent({
	setup(_, { slots }) {
		return () => slots.default?.();
	},
});

export default defineComponent({
	props: {
		form: {
			type: Object as PropType<Form>,
			required: true,
		},
		errors: {
			type: Object as PropType<Record<string, string>>,
			required: true,
		},
	},
	setup(props) {
		return () =>
			h(
				FragmentWrapper,
				{},
				{
					default: getComponents(props.form.schema, props.errors),
				},
			);
	},
});
