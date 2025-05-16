import { computed, reactive } from "vue";
import type { VisitOptions } from "@inertiajs/core";
import { useSimplePaginator } from "./simple";

export function usePaginator<
	Data extends Record<string, any>,
	Props extends Record<string, any> = Record<string, any>,
>(
	dataOrProps: Props | Paginator<Data> | PaginatorResource<Data>,
	keyOrOptions: keyof Props | VisitOptions | null = null,
	options: VisitOptions = {},
) {
	const paginator = useSimplePaginator(dataOrProps, keyOrOptions, options);

	/**
	 * Get the last page url.
	 */
	const last = computed(() =>
		paginator.isResource
			? (paginator.source as unknown as PaginatorResource<Data>).links.last
			: (paginator.source as unknown as Paginator<Data>).last_page_url,
	);

	/**
	 * Get the total number of records.
	 */
	const total = computed(() =>
		paginator.isResource
			? (paginator.source as unknown as PaginatorResource<Data>).meta.total
			: (paginator.source as unknown as Paginator<Data>).total,
	);

	const links = computed(() =>
		(paginator.isResource
			? (paginator.source as unknown as PaginatorResource<Data>).meta.links
			: (paginator.source as unknown as Paginator<Data>).links
		).map((link) => ({
			...link,
			get: () => paginator.navigate(link.url),
		})),
	);

	/**
	 * Get the statement of the paginator.
	 */
	const statement = computed(
		() =>
			`Showing ${paginator.from} to ${paginator.to} of ${total.value} records`,
	);

	/**
	 * Perform a navigation to the last page url.
	 */
	function toLast(options: VisitOptions = {}) {
		const url = last.value;
		paginator.navigate(url, options);
	}

	return reactive({
		...paginator,
		toLast,
		links,
		total,
		statement,
	});
}

export type UsePaginator = ReturnType<typeof usePaginator>;
