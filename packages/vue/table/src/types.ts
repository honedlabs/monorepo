import type { VisitOptions } from "@inertiajs/core";
import type { InlineOperation, BulkOperation, PageOperation, MaybeId, MaybeEndpoint } from "@honed/action";
import type { Refine } from "@honed/refine";
import type { Paginate, PaginateMap, PageOption } from "./paginate";
import type { BaseColumn, Column, Heading } from "./columns";

export type Identifier = string | number;

export type TableEntry<RecordType extends Record<string, any> = any> = {
	[K in keyof RecordType]: {
		v: RecordType[K];
		e: any
		c: string | null
		f: boolean
	};
};

export interface EmptyState {
	title: string
	description: string
	icon?: string
	operations: PageOperation[]
}

export interface View {
	id: number
	name: string
	view: string
}

export interface Table<
	T extends Record<string, any> = Record<string, any>,
	K extends Paginate = "length-aware"
> extends Refine {
	id: MaybeId
	endpoint: MaybeEndpoint
	key: string
	column?: string
	record?: string
	page?: string
	records: Array<TableEntry<T> & { actions: InlineOperation[] }>;
	paginate: PaginateMap[K]
	columns: BaseColumn<T>[];
	pages: PageOption[];
	toggleable: boolean;
	operations: {
		inline: boolean;
		bulk: BulkOperation[];
		page: PageOperation[];
	};
	emptyState?: EmptyState;
	views?: View[]
	meta: Record<string, any>;
}

export interface TableRecord<
	RecordType extends Record<string, any> = Record<string, any>,
> {
	record: RecordType;
	default: (options?: VisitOptions) => void;
	actions: InlineOperation[];
	select: () => void;
	deselect: () => void;
	toggle: () => void;
	selected: boolean;
	bind: () => Record<string, any>;
	value: (column: Column<RecordType> | string) => any;
	extra: (column: Column<RecordType> | string) => any;
}

export interface TableOptions<
	RecordType extends Record<string, any> = Record<string, any>,
> {
	/**
	 * Actions to be applied on a record in JavaScript.
	 */
	recordActions?: Record<string, (record: TableEntry<RecordType>) => void>;
}
