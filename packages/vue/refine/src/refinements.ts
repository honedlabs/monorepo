import { router } from '@inertiajs/vue3'
import type { VisitOptions } from '@inertiajs/core'
import { computed, nextTick, reactive, ref, watch } from 'vue'
import { watchPausable } from '@vueuse/core'
import { type CalendarDateTime } from '@internationalized/date'

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
    type: 'set' | 'callback' | 'exact' | 'similar' | 'boolean' | 'date' | string
    value: any
}

export type FilterBinding<T extends FilterRefinement, U extends any = any> = 
	T extends { type: 'similar' } ? string :
		T extends { type: 'boolean' } ? boolean :
			T extends { type: 'set', multiple: true } ? U[] :
				T extends { type: 'date' } 
					? CalendarDateTime|null
					: U

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
	columns?: string[]
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
	T extends object,
	K extends { [U in keyof T]: T[U] extends Refinements ? U : never }[keyof T],
>(
	props: T, 
    key: K,
    options: RefinementOptions = {}
) {
	const refinements = computed(() => props[key] as Refinements)

	const sortsKey = computed(() => refinements.value.keys.sorts)
    const searchKey = computed(() => refinements.value.keys.search)
    const columnsKey = computed(() => refinements.value.keys.columns)

    const currentSort = computed(() => refinements.value.sorts.find(({ active }) => active))
	const currentFilters = computed(() => refinements.value.filters.filter(({ active }) => active))

	const state = reactive<Record<string, any>>({})

	function initializeState() {
		state[searchKey.value] = refinements.value.search
		state[sortsKey.value] = currentSort.value?.direction
		state[columnsKey.value] = refinements.value.columns
		
		refinements.value.filters.forEach((filter) => {
			state[filter.name] = filter.value
		})
	}

	initializeState()

	// watchPausable(refinements.value, () => {
	// 	initializeState()
	// }, {
	// 	immediate: true,
	// })

	const {
		watch = true,
		...visitOptions
	} = options



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

        router.reload({
            ...visitOptions,
            ...options,
            data
        })
    }

	function getSort(name: string): SortRefinement | undefined {
		return refinements.value.sorts.find((sort) => sort.name === name)
	}

	function getFilter(name: string): FilterRefinement | undefined {
		return refinements.value.filters.find((sort) => sort.name === name)
	}

	function applySearch(value: string, options: VisitOptions = {}) {
		state[searchKey.value] = value
		return refine(options)
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


	function clearSort() {
		state[sortsKey.value] = undefined
		return refine()
	}

	function clearSearch() {
		state[searchKey.value] = ''
		return refine()
	}


	function reset(options: VisitOptions = {}) {
		for (const key in state) {
			state[key] = undefined
		}

		return refine(options)
	}


	return {
		filters: computed(() => refinements.value.filters.map((filter) => ({
			...filter,
			// bind: (value: any) => state[filter.name] = value,
			apply: (v: any) => applyFilter(filter.name, v),
			clear: () => clearFilters(filter.name),
		}))),
		sorts: computed(() => refinements.value.sorts.map((sort) => ({
			...sort,
			toggle: () => applySort(sort.name),
		}))),
		searches: computed(() => refinements.value.searches.map((search) => ({
			...search,
			// bind: (value: string) => baseSearch.value = value,
			toggle: () => applySearch(search.name),
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
		clearSearch,
		reset,
		refine,
	}
}