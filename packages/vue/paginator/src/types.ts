import type {
	BasePaginator,
	BasePaginatorResource,
	BasePaginatorMeta,
} from "./base";

export type Pagination = "length-aware" | "cursor" | "simple";

export interface PaginatorLink {
	url: string | null | undefined;
	label: string;
	active: boolean;
}

export interface SimplePaginatorMeta extends BasePaginatorMeta {
	current_page: number;
	from: number;
	to: number;
}

export interface CursorPaginatorMeta extends BasePaginatorMeta {
	next_cursor: string | null;
	prev_cursor: string | null;
}

export interface PaginatorMeta extends SimplePaginatorMeta {
	last_page: number;
	links: PaginatorLink[];
	total: number;
}

export interface SimplePaginatorResource<T = Record<string, any>>
	extends BasePaginatorResource<T> {
	links: {
		first: string;
		next: string | null;
		prev: string | null;
	};
	meta: SimplePaginatorMeta;
}

export interface SimplePaginator<T = Record<string, any>>
	extends BasePaginator<T>,
		SimplePaginatorMeta {
	first_page_url: string;
}

export interface CursorPaginatorResource<T = Record<string, any>>
	extends BasePaginatorResource<T> {
	meta: CursorPaginatorMeta;
}

export interface CursorPaginator<T = Record<string, any>>
	extends BasePaginator<T>,
		CursorPaginatorMeta {}

export interface PaginatorResource<T = Record<string, any>>
	extends BasePaginatorResource<T> {
	meta: PaginatorMeta;
	links: {
		first: string;
		last: string;
		prev: string | null;
		next: string | null;
	};
}

export interface Paginator<T = Record<string, any>>
	extends BasePaginator<T>,
		PaginatorMeta {
	first_page_url: string;
	last_page_url: string;
	links: PaginatorLink[];
}

export type LengthAwarePaginatorResource<T = Record<string, any>> =
	PaginatorResource<T>;

export type LengthAwarePaginator<T = Record<string, any>> = Paginator<T>;
