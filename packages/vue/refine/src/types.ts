import type { VisitOptions } from "@inertiajs/core";
import type { PromisifyFn } from "@vueuse/shared";

export type Direction = "asc" | "desc" | null;

export interface Option {
	label: string;
	value: FilterValue;
	active: boolean;
}

export interface Refiner {
	name: string;
	label: string;
	type?: string;
	active: boolean;
	meta: Record<string, any>;
}

export type FilterType =
	| "boolean"
	| "date"
	| "datetime"
	| "multiple"
	| "number"
	| "select"
	| "text"
	| "time"
	| "trashed"
	| string;

export type FilterValue = string | number | boolean | null;

export interface Filter extends Refiner {
	type: FilterType;
	value: FilterValue;
	options: Option[];
}

export interface Sort extends Refiner {
	type: "sort" | string;
	direction: Direction;
	next: string | null;
}

export interface Search extends Refiner {
	type: "search" | string;
}

export interface Refine {
	sort?: string;
	search?: string;
	match?: string;
	term?: string;
	placeholder?: string;
	delimiter: string;
	sorts: Sort[];
	filters: Filter[];
	searches: Search[];
}

export interface HonedFilter extends Filter {
	apply: (value: any, options?: VisitOptions) => void;
	clear: (options?: VisitOptions) => void;
	bind: () =>
		| {
				"onUpdate:modelValue": PromisifyFn<(value: any) => void>;
				modelValue: unknown;
		  }
		| undefined;
}

export interface HonedSort extends Sort {
	apply: (options?: VisitOptions) => void;
	clear: (options?: VisitOptions) => void;
	bind: () =>
		| {
				onClick: PromisifyFn<() => void>;
		  }
		| undefined;
}

export interface HonedSearch extends Search {
	apply: (options?: VisitOptions) => void;
	clear: (options?: VisitOptions) => void;
	bind: () =>
		| {
				"onUpdate:modelValue": PromisifyFn<(value: any) => void>;
				modelValue: boolean;
				value: string;
		  }
		| undefined;
}

export interface BindingOptions extends VisitOptions {
	/**
	 * Transform the value before it is applied.
	 */
	transform?: (value: any) => any;

	/**
	 * The debounce time in milliseconds.
	 *
	 * @default 250
	 */
	debounce?: number;
}
