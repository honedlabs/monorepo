import type { VisitOptions } from "@inertiajs/core";

export type Direction = "asc" | "desc" | null;

export interface Option {
	label: string;
	value: FilterValue;
	active: boolean;
}

export interface Refiner {
	name: string;
	label: string;
	type: string;
	active: boolean;
	meta: Record<string, any>;
}

export type FilterType =
	| "boolean"
	| "date"
	| "datetime"
	| "filter"
	| "multiple"
	| "number"
	| "text"
	| "time"
	| string;

export type FilterValue = string | number | boolean | null;

export interface Filter extends Refiner {
	type: FilterType;
	value: FilterValue;
	options: Option[];
	multiple: boolean;
}

export interface Sort extends Refiner {
	type: "sort" | string;
	direction: Direction;
	next: string | null;
}

export interface Search extends Refiner {
	type: "search" | string;
}

export interface Config {
	delimiter: string;
	term: string | null;
	sort: string;
	search: string;
	match: string;
}

export interface Refine {
	config: Config;
	sorts?: Sort[];
	filters?: Filter[];
	searches?: Search[];
}

export interface HonedFilter extends Filter {
	apply: (value: any, options: VisitOptions) => void;
	clear: (options: VisitOptions) => void;
	bind: () => void;
}

export interface HonedSort extends Sort {
	apply: (options: VisitOptions) => void;
	clear: (options: VisitOptions) => void;
	bind: () => void;
}

export interface HonedSearch extends Search {
	apply: (options: VisitOptions) => void;
	clear: (options: VisitOptions) => void;
	bind: () => void;
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
