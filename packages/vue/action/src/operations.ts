import type { Method } from "@inertiajs/core";

interface Route {
	url: string;
	method: Method;
}

export type OperationType = "inline" | "page" | "bulk";

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
	type: OperationType;
	icon?: string;
	extra?: Record<string, unknown>;
	action?: boolean;
	confirm?: Confirm;
	route?: Route;
}

export interface InlineOperation extends Operation {
	type: "inline";
	default: boolean;
}

export interface BulkOperation extends Operation {
	type: "bulk";
	keepSelected: boolean;
}

export interface PageOperation extends Operation {
	type: "page";
}

export type Operations = InlineOperation | BulkOperation | PageOperation;
