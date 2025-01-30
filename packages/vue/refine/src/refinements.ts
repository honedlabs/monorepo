import { router } from '@inertiajs/vue3'
import type { VisitOptions } from '@inertiajs/core'
import { computed, nextTick, reactive, ref, watch } from 'vue'
import { watchPausable } from '@vueuse/core'
import { type CalendarDateTime } from '@internationalized/date'

export type SortDirection = 'asc' | 'desc'

export interface Refinement {
    name: string
    label: string
    type: string
    active: boolean
    meta: Record<string, any>
}

export interface FilterRefinement extends Refinement {
    type: 'set' | 'callback' | 'exact' | 'similar' | 'boolean' | 'date' | string
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
	search: {
		value: string
		matches: string[]
	}
    keys: {
        sorts: string
        search: string
        matches: string
    }
}

export interface SortOptions extends VisitOptions {
	direction?: SortDirection
}

export type FilterBinding<T extends FilterRefinement, U extends any = any> = 
	T extends { type: 'similar' } ? string :
		T extends { type: 'boolean' } ? boolean :
			T extends { type: 'set', multiple: true } ? U[] :
				T extends { type: 'date' } 
					? CalendarDateTime|null
					: U

export function useRefinements<
	T extends object,
	K extends { [U in keyof T]: T[U] extends Refinements ? U : never }[keyof T],
>(
	props: T,
    key: K,
    defaultOptions: VisitOptions = {}
) {
	const refinements = computed(() => props[key] as Refinements)

	const sortsKey = computed(() => refinements.value.keys.sorts)
    const searchKey = computed(() => refinements.value.keys.search)
    const matchesKey = computed(() => refinements.value.keys.matches)

    const currentSort = computed(() => refinements.value.sorts.find(({ active }) => active))
	const currentFilters = computed(() => refinements.value.filters.filter(({ active }) => active))
	const currentSearches = computed(() => refinements.value.searches.filter(({ active }) => active))
	
	const state = reactive<Record<
		typeof searchKey.value, string
	> & Record<
		typeof sortsKey.value, SortDirection | undefined
	> & Record<
		typeof matchesKey.value, string[] | undefined
	> & {
		[F in Refinements['filters'][number] as F['name']]: FilterBinding<F>
	}>({})

	function updateState() {
		state[searchKey.value] = refinements.value.search.value
		state[sortsKey.value] = currentSort.value?.direction
		state[matchesKey.value] = refinements.value.search.matches
		
		refinements.value.filters.forEach((filter) => {
			state[filter.name] = filter.value
		})
	}

    function refine(options: VisitOptions = {}) {
        const data: Record<string, any> = {}
        
        for (const key in state) {
            const value = state[key]

            if ([null, '', []].includes(value)) {
                data[key] = undefined
            } else if (Array.isArray(value)) {
                data[key] = value.join(',')
            } else {
                data[key] = value
            }
        }

		data[searchKey.value] = (data[searchKey.value] ?? '').toLowerCase().replace(/[\s./]/g, '+')

        router.reload({
            ...defaultOptions,
            ...options,
            data
        })
    }

	function getFilter(name: string): FilterRefinement | undefined {
		return refinements.value.filters.find((sort) => sort.name === name)
	}

	function getSort(name: string): SortRefinement | undefined {
		return refinements.value.sorts.find((sort) => sort.name === name)
	}

	function getMatch(name: string): SearchRefinement | undefined {
		return refinements.value.searches.find((search) => search.name === name)
	}

	function applyFilter(name: string, value: any, options: VisitOptions = {}) {
		const filter = getFilter(name)

		if (!filter) {
			console.warn(`[Refinement] Filter "${name}" does not exist.`)
			return
		}

		state[name] = value

		return refine(options)
	}

	function applySort(name: string, options: SortOptions = {}) {
		const sort = getSort(name)

		if (!sort) {
			console.warn(`[Refinement] Sort "${name}" does not exist.`)
			return
		}

		state[name] = options?.direction ?? sort.next

		return refine(options)
	}

	function applySearch(value: string, options: VisitOptions = {}) {
		state[searchKey.value] = value

		return refine(options)
	}

	function applyMatch(name: string, options: VisitOptions = {}) {
		if (! Array.isArray(state[matchesKey.value])) {
			state[matchesKey.value] = []
		}

		const i = state[matchesKey.value].indexOf(name)

		if (i !== -1) {
			state[matchesKey.value].splice(i, 1)
		} else {
			state[matchesKey.value].push(name)
		}

		return refine(options)
	}

	function isFiltering(name?: string): boolean {
		if (name) {
			return currentFilters.value.some((filter) => filter.name === name)
		}

		return currentFilters.value.length !== 0
	}

	function isSorting(name?: string, direction?: SortDirection): boolean {
		if (name) {
			return refinements.value.sorts.some((sort) => sort.name === name && (direction ? sort.direction === direction : true))
		}

		return !!currentSort.value
	}

	function isSearching(name?: string): boolean {
		if (name) {
			return currentSearches.value.some((search) => search.name === name)
		}

		return refinements.value.search.value !== ''
	}

	function clearFilters(...filters: (string) []) {
		if (filters.length === 0) {

			for (const key in state) {
				state[key] = undefined
			}
		} else {
			filters.forEach((filter) => {
				state[filter] = undefined
			})
		}

		return refine()
	}

	function clearSort(options: VisitOptions = {}) {
		state[sortsKey.value] = undefined

		return refine(options)
	}

	function clearSearch(options: VisitOptions = {}) {
		state[searchKey.value] = ''

		return refine(options)
	}

	function clearMatches(options: VisitOptions = {}) {
		state[matchesKey.value] = []

		return refine(options)
	}

	function reset(options: VisitOptions = {}) {
		for (const key in state) {
			state[key] = undefined
		}

		return refine(options)
	}

	updateState()

	return {
		state,
		filters: computed(() => refinements.value.filters.map((filter) => ({
			...filter,
			apply: (v: FilterBinding<typeof filter>) => applyFilter(filter.name, v),
			clear: () => clearFilters(filter.name),
		}))),
		sorts: computed(() => refinements.value.sorts.map((sort) => ({
			...sort,
			toggle: () => applySort(sort.name),
		}))),
		searches: computed(() => refinements.value.searches.map((search) => ({
			...search,
			toggle: () => applyMatch(search.name),
		}))),
		currentSort,
		currentFilters,
		currentSearches,
		refine,
		getFilter,
		getSort,
		getMatch,
		applyFilter,
		applySort,
		applySearch,
		applyMatch,
		isFiltering,
		isSorting,
		isSearching,
		clearFilters,
		clearSort,
		clearSearch,
		clearMatches,
		reset,
	}
}