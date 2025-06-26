import { ComputedRef, Ref } from "vue";
import type { VisitOptions } from "@inertiajs/core";
import type { HonedRefine, Refine } from "@honed/refine";
import type {
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
import type { BaseColumn, Column, Heading } from "./columns";
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

export interface PageBinding {
	"onUpdate:modelValue": (checked: boolean | "indeterminate") => void;
	modelValue: boolean;
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

export interface HonedTable<
	T extends Record<string, any> = Record<string, any>,
	K extends Paginate = "length-aware",
> extends HonedRefine {
	meta: ComputedRef<Record<string, any> | null>;
	isPageable: ComputedRef<boolean>;
	isToggleable: ComputedRef<boolean>;
	getRecordKey: (record: TableEntry<T>) => Identifier;
	headings: ComputedRef<Heading<T>[]>;
	columns: ComputedRef<Column<T>[]>;
	records: ComputedRef<TableRecord<T>[]>;
	inline: ComputedRef<boolean>;
	bulk: ComputedRef<Executable<BulkOperation>[]>;
	page: ComputedRef<Executable<PageOperation>[]>;
	pages: ComputedRef<PageOption[]>;
	currentPage: ComputedRef<PageOption | undefined>;
	paginator: ComputedRef<PaginateMap[K]>;
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
	selection: Ref<BulkSelection<Identifier>, BulkSelection<Identifier>>;
	select: (record: TableEntry<T>) => void;
	deselect: (record: TableEntry<T>) => void;
	toggle: (record: TableEntry<T>) => void;
	selectPage: () => void;
	deselectPage: () => void;
	selected: (record: TableEntry<T>) => boolean;
	selectAll: () => void;
	deselectAll: () => void;
	isPageSelected: ComputedRef<boolean>;
	hasSelected: ComputedRef<boolean>;
	bindCheckbox: (record: TableEntry<T>) => void;
	bindPage: () => void;
	bindAll: () => void;
}

export * from "./columns";
export * from "./paginate";
export * from "./records";
