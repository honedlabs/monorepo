import { h, type VNode } from "vue";
import { resolve } from "./resolver";
import type { Component, Field, Grouping } from "./types";

export function getComponent(
	formComponent: Component,
	errors: Record<string, string> = {},
): VNode {
	const { component, attributes = {}, ...props } = formComponent;

	const { schema, ...rest } = props as Grouping;

	const additional =
		"name" in rest ? { error: errors[(rest as Field).name] } : {};

	return h(
		resolve(component),
		{
			...attributes,
			...rest,
			...additional,
		},
		[...getComponents(schema, errors)],
	);
}

export function getComponents(
	schema?: Component[],
	errors?: Record<string, string>,
): VNode[] {
	if (schema === undefined) return [];

	return schema.map((component: Component) => getComponent(component, errors));
}
