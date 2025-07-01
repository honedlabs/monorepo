import type { Method } from "@inertiajs/core";

export interface Route {
	url: string;
	method: Method;
}

export type OperationType = "inertia" | "anchor";

export interface Confirm {
	title: string;
	description: string | null;
	dismiss: string;
	submit: string;
	intent: "constructive" | "destructive" | "informative" | string;
}

export interface Operation {
	name: string;
	label: string;
	icon?: string;
	confirm?: Confirm;
	type?: OperationType;
	href?: string;
	method?: Method;
	target?: string;
}

export interface InlineOperation extends Operation {
	default: boolean;
}

export interface BulkOperation extends Operation {
	keep: boolean;
}

export interface PageOperation extends Operation {}

export type Operations = InlineOperation | BulkOperation | PageOperation;
