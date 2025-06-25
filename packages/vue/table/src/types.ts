import type { VisitOptions } from "@inertiajs/core";
import type {
	InlineOperation,
	BulkOperation,
	PageOperation,
	MaybeId,
	MaybeEndpoint,
	PageOperationData,
	BulkSelection,
} from "@honed/action";
import type { Refine } from "@honed/refine";
import type { Paginate, PaginateMap, PageOption } from "./paginate";
import type { BaseColumn, Column, Heading } from "./columns";
import { ComputedRef, Ref } from "vue";

export type Identifier = string | number;

export type TableEntry<RecordType extends Record<string, any> = any> = {
	[K in keyof RecordType]: {
		v: RecordType[K];
		e: any;
		c: string | null;
		f: boolean;
	};
};

export interface EmptyState {
	title: string;
	description: string;
	icon?: string;
	operations: PageOperation[];
}

export interface View {
	id: number;
	name: string;
	view: string;
}

export interface Table<
	T extends Record<string, any> = Record<string, any>,
	K extends Paginate = "length-aware",
> extends Refine {
	id: MaybeId;
	endpoint: MaybeEndpoint;
	key: string;
	column?: string;
	record?: string;
	page?: string;
	records: Array<TableEntry<T> & { operations: InlineOperation[] }>;
	paginate: PaginateMap[K];
	columns: BaseColumn<T>[];
	pages: PageOption[];
	toggleable: boolean;
	operations: {
		inline: boolean;
		bulk: BulkOperation[];
		page: PageOperation[];
	};
	emptyState?: EmptyState;
	views?: View[];
	meta: Record<string, any>;
}

export interface TableRecord<
	RecordType extends Record<string, any> = Record<string, any>,
> {
	record: RecordType;
	default: (options?: VisitOptions) => void;
	operations: InlineOperation[];
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
> extends VisitOptions {
	/**
	 * Mappings of operations to be applied on a record in JavaScript.
	 */
	recordOperations?: Record<string, (record: TableEntry<RecordType>) => void>;
}

export interface HonedTable<
	T extends Record<string, any> = Record<string, any>,
	K extends Paginate = "length-aware",
> {
	meta: ComputedRef<Record<string, any>|null>;
	isPageable: ComputedRef<boolean>;
	isToggleable: ComputedRef<boolean>;
	getRecordKey: (record: TableEntry<T>) => Identifier;
	headings: ComputedRef<Heading<T>[]>;
	columns: ComputedRef<Column<T>[]>;
	records: ComputedRef<TableRecord<T>[]>;
	inline: ComputedRef<boolean>;
	bulk: ComputedRef<InlineOperation[]>;
	page: ComputedRef<PageOperation[]>;
	pages: ComputedRef<PageOption[]>;
	currentPage: ComputedRef<PageOption|null>;
	paginator: ComputedRef<PaginateMap[K]>;
	executeInline: (operation: InlineOperation, data: TableEntry<T>, options?: VisitOptions) => void;
	executeBulk: (operation: BulkOperation, options?: VisitOptions) => void;
	executePage: (operation: PageOperation, data?: PageOperationData, options?: VisitOptions) => void;
	applyPage: (page: PageOption, options?: VisitOptions) => void;
	selection: Ref<BulkSelection<Identifier>, BulkSelection<Identifier>>
	select: (record: TableEntry<T>) => void;
	deselect: (record: TableEntry<T>) => void;
	toggle: (record: TableEntry<T>) => void;
	selected: (record: TableEntry<T>) => boolean;
	selectAll: () => void;
	deselectAll: () => void;
	isPageSelected: ComputedRef<boolean>;
	hasSelection: ComputedRef<boolean>;
	bindCheckbox: (record: TableEntry<T>) => void;
	bindPage: () => void
	bindAll: () => void	
}

export * from "./columns";
export * from "./paginate";
