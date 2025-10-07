import type { VisitOptions } from "@inertiajs/core";
import type {
	Filter,
	FilterBinding,
	FilterValue,
	HonedFilter,
} from "./filters";
import type { Sort, HonedSort, Direction, SortBinding } from "./sorts";
import type {
	Search,
	HonedSearch,
	SearchBinding,
	MatchBinding,
} from "./searches";

export interface Refine {
	_sort_key?: string;
	_search_key?: string;
	_match_key?: string;
	_delimiter: string;
	term?: string;
	placeholder?: string;
	sorts: Sort[];
	filters: Filter[];
	searches: Search[];
}

export interface ApplyOptions extends VisitOptions {
	/**
	 * Additional parameters to apply.
	 */
	parameters?: Record<string, any>;
}

export interface BindingOptions extends ApplyOptions {
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

export interface HonedRefine {
	filters: HonedFilter[];
	sorts: HonedSort[];
	searches: HonedSearch[];
	currentFilters: HonedFilter[];
	currentSort: HonedSort | undefined;
	currentSearches: HonedSearch[];
	isSortable: boolean;
	isSearchable: boolean;
	isMatchable: boolean;
	searchTerm: string | null | undefined;
	isFiltering: (name?: Filter | string) => boolean;
	isSorting: (name?: Sort | string) => boolean;
	isSearching: (name?: Search | string) => boolean;
	getFilter: (filter: Filter | string) => Filter | undefined;
	getSort: (sort: Sort | string, dir?: Direction) => Sort | undefined;
	getSearch: (search: Search | string) => Search | undefined;
	apply: (values: Record<string, FilterValue>, options?: VisitOptions) => void;
	applyFilter: (
		filter: Filter | string,
		value: any,
		options?: ApplyOptions,
	) => void;
	applySort: (
		sort: Sort | string,
		direction?: Direction,
		options?: ApplyOptions,
	) => void;
	applySearch: (
		value: string | null | undefined,
		options?: ApplyOptions,
	) => void;
	applyMatch: (search: Search | string, options?: ApplyOptions) => void;
	clearFilter: (filter?: Filter | string, options?: ApplyOptions) => void;
	clearSort: (options?: ApplyOptions) => void;
	clearSearch: (options?: ApplyOptions) => void;
	clearMatch: (options?: ApplyOptions) => void;
	reset: (options?: ApplyOptions) => void;
	bindFilter: (
		filter: Filter | string,
		options?: BindingOptions,
	) => FilterBinding | void;
	bindSort: (
		sort: Sort | string,
		options?: BindingOptions,
	) => SortBinding | void;
	bindSearch: (options?: BindingOptions) => SearchBinding | void;
	bindMatch: (
		match: Search | string,
		options?: BindingOptions,
	) => MatchBinding | void;
	stringValue: (value: any) => any;
	omitValue: (value: any) => any;
	toggleValue: (value: any, values: any) => any;
	delimitArray: (value: any) => string;
}

export type * from "./filters";
export type * from "./sorts";
export type * from "./searches";
export type * from "./refiner";
