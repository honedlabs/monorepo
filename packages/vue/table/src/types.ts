import { computed, reactive } from "vue";
import type { VisitOptions } from "@inertiajs/core";
import { router } from "@inertiajs/vue3";
import { useBulk, executeAction } from "@honed/action";
import type { InlineAction, BulkAction, PageAction } from "@honed/action";
import { useRefine } from "@honed/refine";
import type { Direction, Refine, Config as RefineConfig } from "@honed/refine";

export type Identifier = string | number;

export interface Config extends RefineConfig {
	endpoint: string;
	key: string;
	record: string;
	column: string;
	page: string;
}

export type PaginatorKind = "cursor" | "length-aware" | "simple" | "collection";

export interface PaginatorLink {
	url: string | null;
	label: string;
	active: boolean;
}

export interface CollectionPaginator {
	empty: boolean;
}

export interface CursorPaginator extends CollectionPaginator {
	prevLink: string | null;
	nextLink: string | null;
	perPage: number;
}

export interface SimplePaginator extends CursorPaginator {
	currentPage: number;
}

export interface LengthAwarePaginator extends SimplePaginator {
	total: number;
	from: number;
	to: number;
	firstLink: string | null;
	lastLink: string | null;
	links: PaginatorLink[];
}

export interface PerPageRecord {
	value: number;
	active: boolean;
}

export interface Column<T extends Record<string, any> = Record<string, any>> {
	name: keyof T;
	label: string;
	type:
		| "array"
		| "badge"
		| "boolean"
		| "currency"
		| "date"
		| "hidden"
		| "key"
		| "number"
		| "text"
		| string;
	hidden: boolean;
	active: boolean;
	toggleable: boolean;
	icon?: string;
	class?: string;
	sort?: {
		active: boolean;
		direction: Direction;
		next: string | null;
	};
}

export type AsRecord<RecordType extends Record<string, any> = any> = {
	[K in keyof RecordType]: {
		value: RecordType[K];
		extra: Record<string, any>;
	};
};

export interface Table<
	RecordType extends Record<string, any> = any,
	Paginator extends PaginatorKind = "length-aware",
> extends Refine {
	config: Config;
	id: string;
	records: Array<AsRecord<RecordType> & { actions: InlineAction[] }>;
	paginator: Paginator extends "length-aware"
		? LengthAwarePaginator
		: Paginator extends "simple"
			? SimplePaginator
			: Paginator extends "cursor"
				? CursorPaginator
				: CollectionPaginator;
	columns?: Column<RecordType>[];
	recordsPerPage?: PerPageRecord[];
	toggleable: boolean;
	actions: {
		hasInline: boolean;
		bulk: BulkAction[];
		page: PageAction[];
	};
	meta: Record<string, any>;
}

export interface TableRecord<
	RecordType extends Record<string, any> = Record<string, any>,
> {
	record: RecordType;
	default: (options?: VisitOptions) => void;
	actions: InlineAction[];
	select: () => void;
	deselect: () => void;
	toggle: () => void;
	selected: boolean;
	bind: () => Record<string, any>;
	value: (column: Column<RecordType> | string) => any;
	extra: (column: Column<RecordType> | string) => any;
}

export interface TableHeading<
	T extends Record<string, any> = Record<string, any>,
> extends Column<T> {
	isSorting: boolean;
	toggleSort: (options: VisitOptions) => void;
}

export interface TableColumn<
	T extends Record<string, any> = Record<string, any>,
> extends Column<T> {
	toggle: (options: VisitOptions) => void;
}

export interface TableOptions<
	RecordType extends Record<string, any> = Record<string, any>,
> {
	/**
	 * Actions to be applied on a record in JavaScript.
	 */
	recordActions?: Record<string, (record: AsRecord<RecordType>) => void>;
}
