import { defineAsyncComponent, ref } from "vue";
import type { Component as VueComponent, VNode } from "vue";
import type { Resolver, ResolveKey } from "./types";

const cache = new Map<string, VueComponent | VNode>();

const mappings = ref<ResolveKey>({});

const resolver = ref<Resolver | null>();

export function resolve(name: string): VueComponent | VNode {
	if (!resolver.value) resolver.value = defaultResolver;

	return resolver.value(name);
}

export function defaultResolver(name: string): VueComponent | VNode {
	if (cache.has(name)) {
		return cache.get(name)!;
	}

	const loader = mappings.value[name];

	if (!loader) {
		throw new Error(`A mapping has not been provided for [${name}]`);
	}

	const component = defineAsyncComponent({ loader });

	cache.set(name, component);

	return component;
}

export function resolveUsing(
	r: Resolver | ResolveKey,
	components: ResolveKey = {},
) {
	if (typeof r === "function") {
		resolver.value = r;
		mappings.value = {
			...mappings.value,
			...components,
		};
	} else
		mappings.value = {
			...mappings.value,
			...r,
		};
}
