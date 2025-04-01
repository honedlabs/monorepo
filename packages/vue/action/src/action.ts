import type { Method, VisitOptions } from "@inertiajs/core";
import { router } from "@inertiajs/vue3";
import { computed, reactive } from "vue";

export type Identifier = string | number;

export interface Route {
	url: string;
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

export interface ActionGroup {
	id?: string;
	endpoint?: string;
	inline: InlineAction[];
	bulk: BulkAction[];
	page: PageAction[];
}

export interface InlineActionData extends Record<string, any> {
	record: Identifier;
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
		router.visit(action.route.url, {
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

export function useActions<
	Props extends object,
	Key extends Props[keyof Props] extends ActionGroup ? keyof Props : never,
>(props: Props, key: Key, defaultOptions: VisitOptions = {}) {
	if (!props || !key || !props[key]) {
		throw new Error(
			"The action group must be provided with valid props and key.",
		);
	}

	const actions = computed(() => props[key] as ActionGroup);

	/**
	 * Get the inline actions.
	 */
	const inline = computed(() =>
		actions.value.inline.map((action) => ({
			...action,
			execute: (data: InlineActionData, options: VisitOptions = {}) =>
				executeInlineAction(action, data, options),
		})),
	);

	/**
	 * Get the bulk actions.
	 */
	const bulk = computed(() =>
		actions.value.bulk.map((action) => ({
			...action,
			execute: (data: BulkActionData, options: VisitOptions = {}) =>
				executeBulkAction(action, data, options),
		})),
	);

	/**
	 * Get the page actions.
	 */
	const page = computed(() =>
		actions.value.page.map((action) => ({
			...action,
			execute: (data: Record<string, any> = {}, options: VisitOptions = {}) =>
				executePageAction(action, data, options),
		})),
	);

	/**
	 * Execute an inline action.
	 */
	function executeInlineAction(
		action: InlineAction,
		data: InlineActionData,
		options: VisitOptions = {},
	) {
		executeAction<"inline">(
			action,
			actions.value.endpoint,
			{
				...data,
				id: actions.value.id,
			},
			{
				...defaultOptions,
				...options,
			},
		);
	}

	/**
	 * Execute a bulk action.
	 */
	function executeBulkAction(
		action: BulkAction,
		data: BulkActionData,
		options: VisitOptions = {},
	) {
		executeAction<"bulk">(
			action,
			actions.value.endpoint,
			{
				...data,
				id: actions.value.id,
			},
			{
				...defaultOptions,
				...options,
			},
		);
	}

	/**
	 * Execute a page action.
	 */
	function executePageAction(
		action: PageAction,
		data: Record<string, any> = {},
		options: VisitOptions = {},
	) {
		executeAction<"page">(
			action,
			actions.value.endpoint,
			{
				...data,
				id: actions.value.id,
			},
			{
				...defaultOptions,
				...options,
			},
		);
	}

	return reactive({
		inline,
		bulk,
		page,
		executeInlineAction,
		executeBulkAction,
		executePageAction,
	});
}
