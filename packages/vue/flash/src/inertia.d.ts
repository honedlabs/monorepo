import "@inertiajs/vue3";
import { Page } from "@inertiajs/core";

export interface Message {
	message: string;
	type?: "success" | "error" | "info" | "warning" | string;
	duration?: number | null;
}

export interface FlashMessage extends Message {
	title?: string | null;
}

declare module "@inertiajs/vue3" {
	export declare function usePage(): Page<{ flash: Message | null }>;
}

export {};
