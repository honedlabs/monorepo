import { ref } from "vue";
import type { FlashCallback, Flash } from "./types";

const resolveCallback = ref<FlashCallback>();

export const resolver = {
	setResolveCallback: (callback: FlashCallback) => {
		resolveCallback.value = callback;
	},
	resolve: (flash: Flash) => resolveCallback.value!(flash),
};
