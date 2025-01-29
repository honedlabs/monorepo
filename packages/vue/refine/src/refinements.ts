import { router } from '@inertiajs/vue3'
import type { VisitOptions } from '@inertiajs/core'
import type { Ref } from 'vue'
import { computed, nextTick, reactive, ref, watch } from 'vue'
import { debouncedRef } from '@vueuse/core'

export type SortDirection = 'asc' | 'desc'

export type AvailableVisitOptions = Omit<VisitOptions, 'url' | 'data'>

export interface Refinement {
    name: string
    label: string
    type: string
    active: boolean
    meta: Record<string, any>
}

export interface FilterRefinement extends Refinement {
    type: 'callback' | 'exact' | string
    value: any
}

export interface SortRefinement extends Refinement {
    type: 'sort'
    direction?: SortDirection
    next?: SortDirection
}

export interface SearchRefinement extends Refinement {
    type: 'search'
}

export interface Refinements {
    filters: FilterRefinement[]
    sorts: SortRefinement[]
    searches: SearchRefinement[]
	search: string
    keys: {
        sorts: string
        search: string
        columns: string
    }
}

export interface RefinementOptions extends VisitOptions {
	debounce?: number
	watch?: boolean
}

export interface SortOptions extends VisitOptions {
	direction?: SortDirection
}

export function useRefinements<
	Properties extends object,
	RefinementsKey extends {
		[K in keyof Properties]: Properties[K] extends Refinements ? K : never;
	}[keyof Properties],
>(
    props: Properties, 
    refinementsKeys: RefinementsKey, 
    options: RefinementOptions = {}
) {
    const state = reactive<Record<string, any>>({})

	const refinements = computed(() => props[refinementsKeys] as Refinements)

	const sortsKey = computed(() => refinements.value.keys.sorts)
    const searchKey = computed(() => refinements.value.keys.search)
    const columnsKey = computed(() => refinements.value.keys.columns)

    const currentSort = computed(() => refinements.value.sorts.find(({ active }) => active))
	const currentFilters = computed(() => refinements.value.filters.filter(({ active }) => active))

	const {
		debounce = 500,
		watch = true,
		...visitOptions
	} = options

	const baseSearch = ref('')
	const search = debouncedRef(baseSearch, debounce)

    function refine(options: VisitOptions = {}) {
        router.reload({
            ...visitOptions,
            ...options,
            data: {
                ...state
            }
        })
    }

	function getSort(name: string): SortRefinement | undefined {
		return refinements.value.sorts.find((sort) => sort.name === name)
	}

	function getFilter(name: string): FilterRefinement | undefined {
		return refinements.value.filters.find((sort) => sort.name === name)
	}

	function applySearch(value: string, options: VisitOptions = {}) {
		return refine(options)
	}

	function applyFilter(name: string, value: any, options: VisitOptions = {}) {
		const filter = getFilter(name)

		if (!filter) {
			console.warn(`[Refinement] Filter "${name}" does not exist.`)
			return
		}

		if (['', null].includes(value)) {
			value = undefined
		}

		return refine(options)
	}

	function applySort(name: string, options: SortOptions = {}) {
		const sort = getSort(name)

		if (!sort) {
			console.warn(`[Refinement] Sort "${name}" does not exist.`)
			return
		}

		const next = options?.direction ?? sort.next

		return refine(options)
	}

	function isSorting(name?: string, direction?: SortDirection): boolean {
		if (name) {
			return refinements.value.sorts.some((sort) => sort.name === name && (direction ? sort.direction === direction : true))
		}

		return !!currentSort.value
	}

	function isFiltering(name?: string): boolean {
		if (name) {
			return currentFilters.value.some((filter) => filter.name === name)
		}

		return currentFilters.value.length !== 0
	}

	function clearFilters(...filters: (keyof any) []) {

	}

	function clearSort() {
		router.reload({
			...visitOptions,
			data: {
				[sortsKey.value]: undefined,
			},
		})
	}

	function clearSearch() {
		baseSearch.value = ''
	}

	function reset(options: VisitOptions = {}) {
		router.reload({
			...visitOptions,
			...options,
		})
	}

	return {
		search,
		filters: computed(() => refinements.value.filters.map((filter) => ({
			...filter,
			// bind: (value: any) => state[filter.name] = value,
			apply: (v: any) => applyFilter(filter.name, v),
			clear: () => clearFilters(filter.name),
		}))),
		sorts: computed(() => refinements.value.sorts.map((sort) => ({
			...sort,
			toggle: () => applySort(sort.name),
			clear: () => clearSort(),
		}))),
		searches: computed(() => refinements.value.searches.map((search) => ({
			...search,
			// bind: (value: string) => baseSearch.value = value,
			toggle: () => applySearch(search.name),
			clear: () => clearSearch(),
		}))),
		getFilter,
		getSort,
		applyFilter,
		applySort,
		applySearch,
		isSorting,
		isFiltering,
		clearFilters,
		clearSort,
		reset,
	}
}