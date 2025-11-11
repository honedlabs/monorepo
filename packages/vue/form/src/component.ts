import { h, defineComponent, type PropType, type VNode } from "vue";
import { Form } from "./types";
import { getComponents } from "./utils";

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
