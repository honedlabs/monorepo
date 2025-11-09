import { defineAsyncComponent, ref, VNode } from "vue";
import type { FormComponent } from "./types";

const cache = new Map<FormComponent, Promise<VNode>>();

const mappings = ref<Record<FormComponent, string>>({});

export function load(name: FormComponent): Promise<VNode> {
	return defineAsyncComponent({
		loader: () => import(mappings.value[name]),
	});
}

export function resolve(name: FormComponent): Promise<VNode> {
	if (!cache.has(name)) {
		const promise = load(name);
		cache.set(name, promise);
		return promise;
	}

	return cache.get(name)!;
}

export function resolveUsing(newMappings: Record<FormComponent, string>) {
	mappings.value = {
		...mappings.value,
		...newMappings,
	};
}
