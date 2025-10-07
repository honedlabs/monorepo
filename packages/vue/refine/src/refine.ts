import { computed, reactive } from "vue";
import { router } from "@inertiajs/vue3";
import { useDebounceFn } from "@vueuse/core";
import type { VisitOptions } from "@inertiajs/core";
import type {
	Refine,
	Filter,
	Sort,
	Search,
	Direction,
	BindingOptions,
	FilterValue,
	HonedFilter,
	HonedSort,
	HonedSearch,
	SortBinding,
	SearchBinding,
	MatchBinding,
	ApplyOptions,
} from "./types";

export function useRefine<T extends Record<string, Refine>>(
	props: T,
	key: keyof T,
	defaults: VisitOptions = {},
) {
	if (!props?.[key]) {
		throw new Error("The refine must be provided with valid props and key.");
	}

	const refinements = computed(() => props[key] as Refine);

	const searchTerm = computed(() => refinements.value.term);

	const isSortable = computed(() => !!refinements.value._sort_key);

	const isSearchable = computed(() => !!refinements.value._search_key);

	const isMatchable = computed(() => !!refinements.value._match_key);

	/**
	 * The available filters.
	 */
	const filters = computed<HonedFilter[]>(() =>
		refinements.value.filters?.map((filter) => ({
			...filter,
			apply: (value: T, options: ApplyOptions = {}) =>
				applyFilter(filter, value, options),
			clear: (options: ApplyOptions = {}) => clearFilter(filter, options),
			bind: () => bindFilter(filter.name),
		})),
	);

	/**
	 * The available sorts.
	 */
	const sorts = computed<HonedSort[]>(() =>
		refinements.value.sorts?.map((sort) => ({
			...sort,
			apply: (options: ApplyOptions = {}) =>
				applySort(sort, sort.direction, options),
			clear: (options: ApplyOptions = {}) => clearSort(options),
			bind: () => bindSort(sort),
		})),
	);

	/**
	 * The available searches.
	 */
	const searches = computed<HonedSearch[]>(() =>
		refinements.value.searches?.map((search) => ({
			...search,
			apply: (options: ApplyOptions = {}) => applyMatch(search, options),
			clear: (options: ApplyOptions = {}) => applyMatch(search, options),
			bind: () => bindMatch(search),
		})),
	);

	/**
	 * The current filters.
	 */
	const currentFilters = computed<HonedFilter[]>(() =>
		filters.value.filter(({ active }) => active),
	);

	/**
	 * The current sort.
	 */
	const currentSort = computed<HonedSort | undefined>(() =>
		sorts.value.find(({ active }) => active),
	);

	/**
	 * The current searches.
	 */
	const currentSearches = computed<HonedSearch[]>(() =>
		searches.value.filter(({ active }) => active),
	);

	/**
	 * Converts an array parameter to a comma-separated string for URL parameters.
	 */
	function delimitArray(value: any) {
		if (Array.isArray(value)) return value.join(refinements.value._delimiter);

		return value;
	}

	/**
	 * Formats a string value for search parameters.
	 */
	function stringValue(value: any) {
		if (typeof value !== "string") return value;

		return value.trim().replace(/\s+/g, "+");
	}

	/**
	 * Returns undefined if the value is an empty string, null, or undefined.
	 */
	function omitValue(value: any) {
		if (["", null, undefined, []].includes(value)) return undefined;

		return value;
	}

	/**
	 * Pipe the given value through the given transforms.
	 */
	function pipe(value: any) {
		return [delimitArray, stringValue, omitValue].reduce(
			(result, transform) => transform(result),
			value,
		);
	}

	/**
	 * Toggle the presence of a value in an array.
	 */
	function toggleValue(value: any, values: any) {
		values = Array.isArray(values) ? values : [values];

		if (values.includes(value))
			return values.filter((item: any) => item !== value);

		return [...values, value];
	}

	/**
	 * Gets a filter by name.
	 */
	function getFilter(filter: Filter | string): Filter | undefined {
		if (typeof filter !== "string") return filter;

		return filters.value.find(({ name }) => name === filter);
	}

	/**
	 * Gets a sort by name.
	 */
	function getSort(
		sort: Sort | string,
		dir: Direction = null,
	): Sort | undefined {
		if (typeof sort !== "string") return sort;

		return sorts.value.find(
			({ name, direction }) => name === sort && direction === dir,
		);
	}

	/**
	 * Gets a search by name.
	 */
	function getSearch(search: Search | string): Search | undefined {
		if (typeof search !== "string") return search;

		return searches.value.find(({ name }) => name === search);
	}

	/**
	 * Whether the given filter is currently active.
	 */
	function isFiltering(name?: Filter | string): boolean {
		if (!name) return !!currentFilters.value.length;

		if (typeof name === "string")
			return currentFilters.value.some((filter) => filter.name === name);

		return name.active;
	}

	/**
	 * Whether the given sort is currently active.
	 */
	function isSorting(name?: Sort | string): boolean {
		if (!name) return !!currentSort.value;

		if (typeof name === "string") return currentSort.value?.name === name;

		return name.active;
	}

	/**
	 * Whether the search is currently active, or on a given match.
	 */
	function isSearching(name?: Search | string): boolean {
		if (!name) return !!searchTerm.value;

		if (typeof name === "string")
			return currentSearches.value?.some((search) => search.name === name);

		return name.active;
	}

	/**
	 * Apply the given values in bulk.
	 */
	function apply(
		values: Record<string, FilterValue>,
		options: VisitOptions = {},
	) {
		const data = Object.fromEntries(
			Object.entries(values).map(([key, value]) => [key, pipe(value)]),
		);

		router.reload({
			...defaults,
			...options,
			data,
		});
	}

	/**
	 * Applies the given filter.
	 */
	function applyFilter(
		filter: Filter | string,
		value: any,
		options: ApplyOptions = {},
	) {
		const refiner = getFilter(filter);

		if (!refiner) return console.warn(`Filter [${filter}] does not exist.`);

		const { parameters, ...visitOptions } = options;

		router.reload({
			...defaults,
			...visitOptions,
			data: {
				[refiner.name]: pipe(value),
				...parameters,
			},
		});
	}

	/**
	 * Applies the given sort.
	 */
	function applySort(
		sort: Sort | string,
		direction: Direction = null,
		options: ApplyOptions = {},
	) {
		if (!isSortable.value)
			return console.warn("Refine cannot perform sorting.");

		const refiner = getSort(sort, direction);

		if (!refiner) return console.warn(`Sort [${sort}] does not exist.`);

		const { parameters, ...visitOptions } = options;

		router.reload({
			...defaults,
			...visitOptions,
			data: {
				[refinements.value._sort_key as string]: omitValue(refiner.next),
				...parameters,
			},
		});
	}

	/**
	 * Applies a text search.
	 */
	function applySearch(
		value: string | null | undefined,
		options: ApplyOptions = {},
	) {
		if (!isSearchable.value)
			return console.warn("Refine cannot perform searching.");

		value = [stringValue, omitValue].reduce(
			(result, transform) => transform(result),
			value,
		);

		const { parameters, ...visitOptions } = options;

		router.reload({
			...defaults,
			...visitOptions,
			data: {
				[refinements.value._search_key as string]: value,
				...parameters,
			},
		});
	}

	/**
	 * Applies the given match.
	 */
	function applyMatch(search: Search | string, options: ApplyOptions = {}) {
		if (!isMatchable.value || !isSearchable.value)
			return console.warn("Refine cannot perform matching.");

		const refiner = getSearch(search);

		if (!refiner) return console.warn(`Match [${search}] does not exist.`);

		const matches = toggleValue(
			refiner.name,
			currentSearches.value.map(({ name }) => name),
		);

		const { parameters, ...visitOptions } = options;

		router.reload({
			...defaults,
			...visitOptions,
			data: {
				[refinements.value._match_key as string]: delimitArray(matches),
				...parameters,
			},
		});
	}

	/**
	 * Clear the given filter.
	 */
	function clearFilter(filter?: Filter | string, options: ApplyOptions = {}) {
		if (filter) return applyFilter(filter, null, options);

		const { parameters, ...visitOptions } = options;

		router.reload({
			...defaults,
			...visitOptions,
			data: {
				...Object.fromEntries(
					currentFilters.value.map(({ name }) => [name, null]),
				),
				...parameters,
			},
		});
	}

	/**
	 * Clear the sort.
	 */
	function clearSort(options: ApplyOptions = {}) {
		if (!isSortable.value)
			return console.warn("Refine cannot perform sorting.");

		const { parameters, ...visitOptions } = options;

		router.reload({
			...defaults,
			...visitOptions,
			data: {
				[refinements.value._sort_key as string]: null,
				...parameters,
			},
		});
	}

	/**
	 * Clear the search.
	 */
	function clearSearch(options: ApplyOptions = {}) {
		applySearch(null, options);
	}

	/**
	 * Clear the matching columns.
	 */
	function clearMatch(options: ApplyOptions = {}) {
		if (!isMatchable.value)
			return console.warn("Refine cannot perform matching.");

		const { parameters, ...visitOptions } = options;

		router.reload({
			...defaults,
			...visitOptions,
			data: {
				[refinements.value._match_key as string]: null,
				...parameters,
			},
		});
	}

	/**
	 * Resets all filters, sorts, matches and search.
	 */
	function reset(options: ApplyOptions = {}) {
		const { parameters, ...visitOptions } = options;

		router.reload({
			...defaults,
			...visitOptions,
			data: {
				[refinements.value._search_key ?? ""]: undefined,
				[refinements.value._sort_key ?? ""]: undefined,
				[refinements.value._match_key ?? ""]: undefined,
				...Object.fromEntries(
					refinements.value.filters?.map((filter) => [
						filter.name,
						undefined,
					]) ?? [],
				),
				...parameters,
			},
		});
	}

	/**
	 * Binds a filter to a form input.
	 */
	function bindFilter(filter: Filter | string, options: BindingOptions = {}) {
		const refiner = getFilter(filter);

		if (!refiner) return console.warn(`Filter [${filter}] does not exist.`);

		const {
			debounce = 150,
			transform = (value: any) => value,
			...visitOptions
		} = options;

		return {
			"onUpdate:modelValue": useDebounceFn((value: any) => {
				applyFilter(refiner, transform(value), visitOptions);
			}, debounce),
			modelValue: refiner.value,
		};
	}

	/**
	 * Binds a sort to a button.
	 */
	function bindSort(
		sort: Sort | string,
		options: BindingOptions = {},
	): SortBinding | void {
		if (!isSortable.value)
			return console.warn("Refine cannot perform sorting.");

		const refiner = getSort(sort);

		if (!refiner) return console.warn(`Sort [${sort}] does not exist.`);

		const { debounce = 0, transform, ...visitOptions } = options;

		return {
			onClick: useDebounceFn(() => {
				applySort(refiner, currentSort.value?.direction, visitOptions);
			}, debounce),
		};
	}

	/**
	 * Binds a search input to a form input.
	 */
	function bindSearch(options: BindingOptions = {}): SearchBinding | void {
		if (!isSearchable.value)
			return console.warn("Refine cannot perform searching.");

		const { debounce = 700, transform, ...visitOptions } = options;

		return {
			"onUpdate:modelValue": useDebounceFn(
				(value: string | null | undefined) => {
					applySearch(value, visitOptions);
				},
				debounce,
			),
			modelValue: searchTerm.value ?? "",
		};
	}

	/**
	 * Binds a match to a checkbox.
	 */
	function bindMatch(
		match: Search | string,
		options: BindingOptions = {},
	): MatchBinding | void {
		if (!isMatchable.value)
			return console.warn("Refine cannot perform matching.");

		const refiner = getSearch(match);

		if (!refiner) return console.warn(`Match [${match}] does not exist.`);

		const { debounce = 0, transform, ...visitOptions } = options;

		return {
			"onUpdate:modelValue": useDebounceFn((value: any) => {
				applyMatch(value, visitOptions);
			}, debounce),
			modelValue: isSearching(refiner),
			value: refiner.name,
		};
	}

	return {
		filters,
		sorts,
		searches,
		currentFilters,
		currentSort,
		currentSearches,
		searchTerm,
		isSortable,
		isSearchable,
		isMatchable,
		isFiltering,
		isSorting,
		isSearching,
		getFilter,
		getSort,
		getSearch,
		apply,
		applyFilter,
		applySort,
		applySearch,
		applyMatch,
		clearFilter,
		clearSort,
		clearSearch,
		clearMatch,
		reset,
		bindFilter,
		bindSort,
		bindSearch,
		bindMatch,
		stringValue,
		omitValue,
		toggleValue,
		delimitArray,
	};
}
