import { computed, reactive } from "vue";
import { router } from "@inertiajs/vue3";
import type { VisitOptions } from "@inertiajs/core";
import { useBasePaginator } from "./base";
import type { SimplePaginator, SimplePaginatorResource } from "./types";

export function useSimplePaginator<
	Data extends Record<string, any>,
	Props extends Record<string, any> = Record<string, any>,
>(
	dataOrProps: Props | SimplePaginator<Data> | SimplePaginatorResource<Data>,
	keyOrOptions: keyof Props | VisitOptions | null = null,
	options: VisitOptions = {},
) {
	const paginator = useBasePaginator(dataOrProps, keyOrOptions, options);

	/**
	 * Get the first page url.
	 */
	const first = computed(() =>
		paginator.isResource
			? (paginator.source as SimplePaginatorResource<Data>).links.first
			: (paginator.source as SimplePaginator<Data>).first_page_url,
	);

	/**
	 * Get the number of records per page.
	 */
	const perPage = computed(() =>
		paginator.isResource
			? (paginator.source as SimplePaginatorResource<Data>).meta.per_page
			: (paginator.source as SimplePaginator<Data>).per_page,
	);

	/**
	 * Get the first record number shown on the current page.
	 */
	const from = computed(() =>
		paginator.isResource
			? (paginator.source as SimplePaginatorResource<Data>).meta.from
			: (paginator.source as SimplePaginator<Data>).from,
	);

	/**
	 * Get the final record number shown on the current page.
	 */
	const to = computed(() =>
		paginator.isResource
			? (paginator.source as SimplePaginatorResource<Data>).meta.to
			: (paginator.source as SimplePaginator<Data>).to,
	);

	/**
	 * Perform a navigation to the first page url.
	 */
	function toFirst(options: VisitOptions = {}) {
		const url = first.value;
		paginator.navigate(url, {
			...options,
		});
	}

	return reactive({
		...paginator,
		first,
		to,
		perPage,
		from,
		toFirst,
	});
}

export type UseSimplePaginator = ReturnType<typeof useSimplePaginator>;
