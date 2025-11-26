import { resolveUsing } from "./resolver";
import type { App } from "vue";
import type { PluginOptions } from "./types";

export const plugin = {
	install(app: App, options: PluginOptions) {
		const components = options.components || {};

		resolveUsing(options.resolver || components, components);
	},
};
