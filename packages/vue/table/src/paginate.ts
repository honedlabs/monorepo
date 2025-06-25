export type Paginate = "cursor" | "length-aware" | "simple" | "collection";

export interface PaginatorLink {
	url: string | null;
	label: string;
	active: boolean;
}

export interface CollectionPaginate {
	empty: boolean;
}

export interface CursorPaginate extends CollectionPaginate {
	prevLink: string | null;
	nextLink: string | null;
	perPage: number;
}

export interface SimplePaginate extends CursorPaginate {
	currentPage: number;
}

export interface LengthAwarePaginate extends SimplePaginate {
	total: number;
	from: number;
	to: number;
	firstLink: string | null;
	lastLink: string | null;
	links: PaginatorLink[];
}

export interface PageOption {
	value: number;
	active: boolean;
}

export type PaginateMap = {
	cursor: CursorPaginate;
	"length-aware": LengthAwarePaginate;
	simple: SimplePaginate;
	collection: CollectionPaginate;
};