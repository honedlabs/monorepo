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
		options?: VisitOptions,
	) => void;
	applySort: (
		sort: Sort | string,
		direction?: Direction,
		options?: VisitOptions,
	) => void;
	applySearch: (
		value: string | null | undefined,
		options?: VisitOptions,
	) => void;
	applyMatch: (search: Search | string, options?: VisitOptions) => void;
	clearFilter: (filter?: Filter | string, options?: VisitOptions) => void;
	clearSort: (options?: VisitOptions) => void;
	clearSearch: (options?: VisitOptions) => void;
	clearMatch: (options?: VisitOptions) => void;
	reset: (options?: VisitOptions) => void;
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
