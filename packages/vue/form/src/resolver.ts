import { defineAsyncComponent, ref, VNode } from "vue";
import type { ResolveKey } from "./types";

const cache = new Map<string, Promise<VNode>>();

const mappings = ref<ResolveKey>({});

export function load(name: string): Promise<VNode> {
	return defineAsyncComponent({
		loader: () => import(mappings.value[name]),
	});
}

export function resolve(name: string): Promise<VNode> {
	if (!cache.has(name)) {
		const promise = load(name);
		cache.set(name, promise);
		return promise;
	}

	return cache.get(name)!;
}

export function resolveUsing(newMappings: ResolveKey) {
	mappings.value = {
		...mappings.value,
		...newMappings,
	};
}
