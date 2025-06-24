import type { Method, VisitOptions } from "@inertiajs/core";

export type Identifier = string | number;

export interface Route {
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

export interface Batch {
	id?: string;
	endpoint?: string;
	inline: InlineOperation[];
	bulk: BulkOperation[];
	page: PageOperation[];
}

export interface InlineOperationData extends Record<string, any> {
	record: Identifier;
}

export interface BulkOperationData extends Record<string, any> {
	all: boolean;
	only: Identifier[];
	except: Identifier[];
}
