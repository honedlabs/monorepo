import { App } from "vue";
import { resolver } from "./resolver";
import { router, usePage } from "@inertiajs/vue3";
import type { Flash, FlashPluginOptions } from "./types";

export const plugin = {
	install(app: App, options: FlashPluginOptions) {
		resolver.setResolveCallback(options.resolve);

		router.on("finish", () => {
			const page = usePage();

			console.log(page);

			const flash = page?.props?.flash as Flash | null;

			if (flash) {
				resolver.resolve(flash);
			}
		});
	},
};
