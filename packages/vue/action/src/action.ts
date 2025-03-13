import type { Method, VisitOptions } from "@inertiajs/core";
import { router } from "@inertiajs/vue3";

export type Identifier = string | number;

export interface Route {
	href: string;
	method: Method;
}

export type ActionType = "inline" | "page" | "bulk";

export interface Confirm {
	title: string;
	description: string | null;
	dismiss: string;
	submit: string;
	intent: "constructive" | "destructive" | "informative" | string;
}

export interface Action {
	name: string;
	label: string;
	type: ActionType;
	icon?: string;
	extra?: Record<string, unknown>;
	action?: boolean;
	confirm?: Confirm;
	route?: Route;
}

export interface InlineAction extends Action {
	type: "inline";
	default: boolean;
}

export interface BulkAction extends Action {
	type: "bulk";
	keepSelected: boolean;
}

export interface PageAction extends Action {
	type: "page";
}

export type ActionGroup = PageAction[];

export interface InlineActionData extends Record<string, any> {
	id: Identifier;
}

export interface BulkActionData extends Record<string, any> {
	all: boolean;
	only: Identifier[];
	except: Identifier[];
}

/**
 * Execute the action.
 */
export function executeAction<T extends ActionType = any>(
	action: T extends "inline"
		? InlineAction
		: T extends "bulk"
			? BulkAction
			: T extends "page"
				? PageAction
				: Action,
	endpoint?: string,
	data: T extends "inline"
		? InlineActionData
		: T extends "bulk"
			? BulkActionData
			: Record<string, any> = {} as any,
	options: VisitOptions = {},
) {
	if (action.route) {
		router.visit(action.route.href, {
			...options,
			method: action.route.method,
		});

		return true;
	}

	if (action.action && endpoint) {
		router.post(
			endpoint,
			{
				...data,
				name: action.name,
				type: action.type,
			},
			options,
		);

		return true;
	}

	return false;
}
