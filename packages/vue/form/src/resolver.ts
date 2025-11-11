import { defineAsyncComponent, ref, VNode } from "vue";
import type { Resolver, ResolveKey } from "./types";

const cache = new Map<string, VNode | Promise<VNode>>();

const mappings = ref<ResolveKey>({});

const resolver = ref<Resolver | null>();

export function resolve(name: string): VNode | Promise<VNode> {
	if (!resolver.value) resolver.value = defaultResolver;

	return resolver.value(name);
}

export function defaultResolver(name: string): Promise<VNode> {
	if (!cache.has(name)) {
		const promise = defineAsyncComponent({
			loader: () => import(mappings.value[name] as string),
		});
		cache.set(name, promise);
		return promise;
	}

	return cache.get(name)! as Promise<VNode>;
}

export function resolveUsing(r: Resolver | ResolveKey) {
	if (typeof r === "function") resolver.value = r;
	else
		mappings.value = {
			...mappings.value,
			...r,
		};
}
