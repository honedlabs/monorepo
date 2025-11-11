import { computed, h, type VNode } from "vue";
import { resolve } from "./resolver";
import type { Component, Field, Grouping } from "./types";
import type { InertiaForm } from "@inertiajs/vue3";

export function getComponent(
	formComponent: Component,
	errors: Record<string, string> = {},
): VNode {
	const { component, attributes = {}, ...props } = formComponent;

	const { schema, ...rest } = props as Grouping;

	const error = computed(() => errors[(rest as Field).name]);

	return h(
		resolve(component),
		{
			...attributes,
			...rest,
			error,
		},
		{
			default: getComponents(schema, errors),
		},
	);
}

export function getComponents(
	schema?: Component[],
	errors?: Record<string, string>,
): () => VNode[] {
	if (schema === undefined) return () => [];

	return () =>
		schema.map((component: Component) => getComponent(component, errors));
}
