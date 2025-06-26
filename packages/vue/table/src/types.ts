import { Ref } from "vue";
import type { VisitOptions } from "@inertiajs/core";
import type { HonedRefine, Refine } from "@honed/refine";
import type {
	RecordBinding,
	Binding,
	InlineOperation,
	BulkOperation,
	PageOperation,
	MaybeId,
	MaybeEndpoint,
	PageOperationData,
	BulkSelection,
	Executable,
} from "@honed/action";
import type { Paginate, PaginateMap, PageOption } from "./paginate";
import type { Column, HonedColumn, Heading } from "./columns";
import type { TableEntry, TableRecord, Identifier } from "./records";

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
	columns: Column<T>[];
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

export interface HonedTable<
	T extends Record<string, any> = Record<string, any>,
	K extends Paginate = "length-aware",
> extends HonedRefine {
	id: Exclude<MaybeId, undefined>;
	meta: Record<string, any> | null;
	emptyState: EmptyState | null;
	views: View[];
	placeholder: string | null;
	isEmpty: boolean;
	isPageable: boolean;
	isToggleable: boolean;
	getRecordKey: (record: TableEntry<T>) => Identifier;
	getEntry: (
		record: TableEntry<T>,
		column: Column<T> | string,
	) => { v: any; e: any; c: string | null; f: boolean } | null;
	getValue: (record: TableEntry<T>, column: Column<T> | string) => any;
	getExtra: (record: TableEntry<T>, column: Column<T> | string) => any;
	headings: Heading<T>[];
	columns: HonedColumn<T>[];
	records: TableRecord<T>[];
	inline: boolean;
	bulk: Executable<BulkOperation>[];
	page: Executable<PageOperation>[];
	pages: PageOption[];
	currentPage: PageOption | undefined;
	paginator: PaginateMap[K];
	executeInline: (
		operation: InlineOperation,
		data: TableEntry<T>,
		options?: VisitOptions,
	) => void;
	executeBulk: (operation: BulkOperation, options?: VisitOptions) => void;
	executePage: (
		operation: PageOperation,
		data?: PageOperationData,
		options?: VisitOptions,
	) => void;
	applyPage: (page: PageOption, options?: VisitOptions) => void;

	selection: BulkSelection<Identifier>;
	select: (record: TableEntry<T>) => void;
	deselect: (record: TableEntry<T>) => void;
	toggle: (record: TableEntry<T>) => void;
	selectPage: () => void;
	deselectPage: () => void;
	selected: (record: TableEntry<T>) => boolean;
	selectAll: () => void;
	deselectAll: () => void;
	isPageSelected: boolean;
	hasSelected: boolean;
	bindCheckbox: (record: TableEntry<T>) => RecordBinding<Identifier>;
	bindPage: () => Binding;
	bindAll: () => Binding;
}

export * from "./columns";
export * from "./paginate";
export * from "./records";
