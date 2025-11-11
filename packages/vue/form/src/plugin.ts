import { resolveUsing } from "./resolver";
import type { App } from "vue";
import type { Resolver, ResolveKey } from "./types";

export const plugin = {
	install(app: App, resolver: Resolver | ResolveKey) {
		resolveUsing(resolver);
	},
};
