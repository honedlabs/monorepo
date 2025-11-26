import { h, type VNode } from "vue";
import { resolve } from "./resolver";
import type { Component, Field, Grouping } from "./types";

export function getComponent(
	formComponent: Component,
	errors: Record<string, string> = {},
): VNode {
	const { component, attributes = {}, ...props } = formComponent;

	const { schema, ...rest } = props as Grouping;

	const error = (rest as Field).name ? errors[(rest as Field).name] : undefined;

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
