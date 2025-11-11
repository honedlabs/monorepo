import { resolveUsing } from "./resolver";
import type { App } from "vue";
import type { ResolveKey } from "./types";

export const plugin = {
	install(app: App, options: ResolveKey) {
		resolveUsing(options);
	},
};
