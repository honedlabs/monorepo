import { computed, reactive } from "vue";
import { router } from "@inertiajs/vue3";
import type { VisitOptions } from "@inertiajs/core";

export interface BasePaginator<T> {
	data: T[];
	next_page_url: string | null;
	prev_page_url: string | null;
}

export interface BasePaginatorMeta {
	path: string;
	per_page: number;
}

export interface BasePaginatorResource<T> {
	data: T[];
	links: {
		next: string | null;
		prev: string | null;
	};
	meta: {
		path: string;
		per_page: number;
	};
}

export function useBasePaginator<
	Data extends Record<string, any>,
	Props extends Record<string, any> = Record<string, any>,
>(
	dataOrProps: Props | BasePaginator<Data> | BasePaginatorResource<Data>,
	keyOrOptions: keyof Props | VisitOptions | null = null,
	options: VisitOptions = {},
) {
	const isKey = typeof keyOrOptions === "string";

	const source = computed<
		SimplePaginator<Data> | SimplePaginatorResource<Data>
	>(() => {
		if (isKey) {
			return (dataOrProps as Props)[
				keyOrOptions
			] as unknown as SimplePaginatorResource<Data>;
		}

		return dataOrProps as SimplePaginator<Data>;
	});

	/**
	 * Check if the pagination comes from a resource paginator or query paginator.
	 */
	const isResource = computed(
		() => typeof source.value === "object" && "meta" in source.value,
	);

	const defaultOptions = {
		...options,

		...(isResource.value
			? {
					only: [
						...((isKey ? (keyOrOptions as any).only : []) as string[]),
						...(isKey ? [keyOrOptions] : []),
					],
				}
			: {}),
	};

	/**
	 * Get the data of the current page.
	 */
	const data = computed(() => source.value.data);

	/**
	 * Get the current page number.
	 */
	const current = computed(() =>
		isResource.value
			? (source.value as SimplePaginatorResource<Data>).meta.current_page
			: (source.value as SimplePaginator<Data>).current_page,
	);

	/**
	 * Get the next page url.
	 */
	const next = computed(() =>
		isResource.value
			? (source.value as SimplePaginatorResource<Data>).links.next
			: (source.value as SimplePaginator<Data>).next_page_url,
	);

	/**
	 * Get the previous page url.
	 */
	const previous = computed(() =>
		isResource.value
			? (source.value as SimplePaginatorResource<Data>).links.prev
			: (source.value as SimplePaginator<Data>).prev_page_url,
	);

	/**
	 * Get the number of records per page.
	 */
	const perPage = computed(() =>
		isResource.value
			? (source.value as SimplePaginatorResource<Data>).meta.per_page
			: (source.value as SimplePaginator<Data>).per_page,
	);

	/**
	 * Perform a navigation to the given pagination url.
	 */
	function navigate(
		url: string | null | undefined,
		options: VisitOptions = {},
	) {
		if (!url) return;

		router.get(
			url,
			{},
			{
				...defaultOptions,
				...options,
			},
		);
	}

	/**
	 * Perform a navigation to the next page url.
	 */
	function toNext(options: VisitOptions = {}) {
		const url = next.value;
		navigate(url, options);
	}

	/**
	 * Perform a navigation to the previous page url.
	 */
	function toPrevious(options: VisitOptions = {}) {
		const url = previous.value;
		navigate(url, options);
	}

	return reactive({
		source,
		data,
		isResource,
		current,
		next,
		previous,
		perPage,
		navigate,
		toNext,
		toPrevious,
	});
}
