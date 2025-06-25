import { computed, reactive } from "vue";
import { router } from "@inertiajs/vue3";
import type { Page, VisitOptions } from "@inertiajs/core";
import {
	useBulk,
	executor as operationExecutor,
	executables as operationExecutables,
} from "@honed/action";
import type {
	InlineOperation,
	BulkOperation,
	PageOperation,
	Operations,
	PageOperationData,
	OperationDataMap,
} from "@honed/action";
import { useRefine, type Sort } from "@honed/refine";
import type {
	Identifier,
	TableEntry,
	Table,
	TableOptions,
	EmptyState,
	PageOption,
	Paginate,
	Column,
	Heading,
} from "./types";

export function useTable<
	T extends Record<string, Table>,
	K extends Record<string, any> = Record<string, any>,
	U extends Paginate = "length-aware",
>(
	props: T,
	key: keyof T,
	defaults: TableOptions = {}
) {

	if (!props?.[key]) {
		throw new Error("The table must be provided with valid props and key.");
	}

	const { recordOperations = {}, ...visitOptions } = {
		only: [...((defaults.only ?? []) as string[]), key.toString()],
		...defaults,
	};

	const table = computed(() => props[key] as Table<K, U>);

	const select = useBulk<Identifier>();

	const refine = useRefine<T>(props, key, visitOptions);

	const meta = computed(() => table.value.meta)

	const isPageable = computed(() => !!table.value.page && !!table.value.record);

	const isToggleable = computed(() => !!table.value.column);

	/**
	 * The heading columns for the table.
	 */
	const headings = computed<Heading<K>[]>(() =>
		table.value.columns
			.filter(({ active, hidden }) => active && !hidden)
			.map((column) => ({
				...column,
				isSorting: !!column.sort?.active,
				toggleSort: (options: VisitOptions = {}) =>
					refine.applySort(column.sort as Sort, null, options),
			})),
	);

	/**
	 * All of the table's columns
	 */
	const columns = computed<Column<K>[]>(() =>
		table.value.columns
			.filter(({ hidden }) => !hidden)
			.map((column) => ({
				...column,
				toggle: (options: VisitOptions = {}) =>
					toggle(column.name as string, options),
			})),
	);

	/**
	 * The records of the table.
	 */
	const records = computed(() =>
		table.value.records.map((record) => ({
			record: (({ operations, ...rest }) => rest)(record),
			/** The operations available for the record */
			operations: executables(record.operations),
			/** Perform this operation when the record is clicked */
			default: (options: VisitOptions = {}) => {
				const use = record.operations.find(
					({ default: isDefault }) => isDefault,
				);

				if (use) executeInline(use, record, options);
			},
			/** Selects this record */
			select: () => select.select(getRecordKey(record)),
			/** Deselects this record */
			deselect: () => select.deselect(getRecordKey(record)),
			/** Toggles the selection of this record */
			toggle: () => select.toggle(getRecordKey(record)),
			/** Determine if the record is selected */
			selected: select.selected(getRecordKey(record)),
			/** Bind the record to a checkbox */
			bind: () => select.bind(getRecordKey(record)),
			/** Get the value of the record for the column */
			value: (column: Column<K> | string) => {
				const name = getColumnName(column);
				return name in record ? record[name].v : null;
			},
			/** Get the extra data of the record for the column */
			extra: (column: Column<K> | string) => {
				const name = getColumnName(column);
				console.log(name, record);
				return name in record ? record[name].e : null;
			},
		})),
	);

	const inline = computed(() => table.value.operations.inline)

	/**
	 * Get the bulk operations.
	 */
	const bulk = computed(() => executables(table.value.operations.bulk));

	/**
	 * Get page operations.
	 */
	const page = computed(() => executables(table.value.operations.page));

	/**
	 * The current number of records to display per page.
	 */
	const currentPage = computed(() =>
		table.value.pages.find(({ active }) => active),
	);

	/**
	 * The available number of records to display per page.
	 */
	const pages = computed(() => table.value.pages)

	/**
	 * The paginator metadata.
	 */
	const paginator = computed(() => ({
		...table.value.paginate,
		next: (options: VisitOptions = {}) => {
			if ("nextLink" in paginator.value && paginator.value.nextLink) {
				toPage(paginator.value.nextLink, options);
			}
		},
		previous: (options: VisitOptions = {}) => {
			if ("prevLink" in paginator.value && paginator.value.prevLink) {
				toPage(paginator.value.prevLink, options);
			}
		},
		first: (options: VisitOptions = {}) => {
			if ("firstLink" in paginator.value && paginator.value.firstLink) {
				toPage(paginator.value.firstLink, options);
			}
		},
		last: (options: VisitOptions = {}) => {
			if ("lastLink" in paginator.value && paginator.value.lastLink) {
				toPage(paginator.value.lastLink, options);
			}
		},
		...("links" in table.value.paginate && table.value.paginate.links
			? {
					links: table.value.paginate.links.map((link) => ({
						...link,
						navigate: (options: VisitOptions = {}) =>
							link.url && toPage(link.url, options),
					})),
				}
			: {}),
	}));

	/**
	 * Whether all records on the current page are selected.
	 */
	const isPageSelected = computed(
		() =>
			table.value.records.length > 0 &&
			table.value.records.every((record: TableEntry<K>) =>
				select.selected(getRecordKey(record)),
			),
	);

	/**
	 * Get the identifier of the record.
	 */
	function getRecordKey(record: TableEntry<K>) {
		return record[table.value.key].v as Identifier;
	}

	/**
	 * Get the name of the column.
	 */
	function getColumnName(column: Column<K> | string) {
		return typeof column === "string" ? column : column.name;
	}

	/**
	 * Execute an operation with common logic
	 */
	function executor<T extends Operations>(
		operation: T,
		data: OperationDataMap[typeof operation.type] = {},
		options: VisitOptions = {},
	) {
		return operationExecutor(
			operation,
			table.value.endpoint,
			table.value.id,
			data,
			{
				...visitOptions,
				...options,
			},
		);
	}

	/**
	 * Create operations with execute methods
	 */
	function executables<T extends Operations>(operations: T[]) {
		return operationExecutables(
			operations,
			table.value.endpoint,
			table.value.id,
			visitOptions,
		);
	}

	/**
	 * Visit a page.
	 */
	function toPage(link: string, options: VisitOptions = {}) {
		router.visit(link, {
			preserveScroll: true,
			preserveState: true,
			...visitOptions,
			...options,
			method: "get",
		});
	}

	function executeInline(
		operation: InlineOperation,
		data: TableEntry<K>,
		options: VisitOptions = {},
	) {
		const success = executor(
			operation,
			{
				record: getRecordKey(data),
			},
			options,
		);

		if (!success) recordOperations?.[operation.name]?.(data);
	}

	/**
	 * Execute a bulk operation.
	 */
	function executeBulk(operation: BulkOperation, options: VisitOptions = {}) {
		executor(
			operation,
			{
				all: select.selection.value.all,
				only: Array.from(select.selection.value.only),
				except: Array.from(select.selection.value.except),
			},
			{
				...options,
				onSuccess: (page: Page) => {
					options.onSuccess?.(page);

					if (!operation.keepSelected) select.deselectAll();
				},
			},
		);
	}

	function executePage(
		operation: PageOperation,
		data: PageOperationData = {},
		options: VisitOptions = {},
	) {
		return executor(operation, data, options);
	}

	/**
	 * Apply a new page by changing the number of records to display.
	 */
	function applyPage(page: PageOption, options: VisitOptions = {}) {
		if (!isPageable.value)
			return console.warn("The table does not support pagination changes.");

		router.reload({
			...visitOptions,
			...options,
			data: {
				[table.value.record as string]: page.value,
				[table.value.page as string]: undefined,
			},
		});
	}

	/**
	 * Toggle a column's visibility.
	 */
	function toggle(column: Column<K> | string, options: VisitOptions = {}) {
		if (!isToggleable.value)
			return console.warn("The table does not support column toggling.");

		const name = getColumnName(column);

		if (!name) return console.log(`Column [${column}] does not exist.`);

		const params = refine.toggleValue(
			name,
			headings.value.map(({ name }) => name),
		);

		router.reload({
			...visitOptions,
			...options,
			data: {
				[table.value.column as string]: refine.delimitArray(params),
			},
		});
	}

	/**
	 * Selects records on the current page.
	 */
	function selectPage() {
		select.select(
			...table.value.records.map((record: TableEntry<K>) =>
				getRecordKey(record),
			),
		);
	}

	/**
	 * Deselects records on the current page.
	 */
	function deselectPage() {
		select.deselect(
			...table.value.records.map((record: TableEntry<K>) =>
				getRecordKey(record),
			),
		);
	}

	/**
	 * Bind the select all checkbox to the current page.
	 */
	function bindPage() {
		return {
			"onUpdate:modelValue": (checked: boolean | "indeterminate") => {
				if (checked) selectPage();
				else deselectPage();
			},
			modelValue: isPageSelected.value,
		};
	}

	return reactive({
		/** Table-specific metadata */
		meta,
		/** Whether the table supports changing the number of records to display per page */
		isPageable,
		/** Whether the table supports toggling columns */
		isToggleable,
		/** Retrieve a record's identifier */
		getRecordKey,
		/** The heading columns for the table */
		headings,
		/** All of the table's columns */
		columns,
		/** The records of the table */
		records,
		/** Whether the table has record operations */
		inline,
		/** The available bulk operations */
		bulk,
		/** The available page operations */
		page,
		/** The available number of records to display per page */
		pages,
		/** The current record per page item */
		currentPage,
		/** The pagination metadata */
		paginator,
		/** Execute an inline operation */
		executeInline,
		/** Execute a bulk operation */
		executeBulk,
		/** Execute a page operation */
		executePage,
		/** Apply a new page by changing the number of records to display */
		applyPage,
		/** The current selection of records */
		selection: select.selection,
		/** Select the given records */
		select: (record: TableEntry<K>) => select.select(getRecordKey(record)),
		/** Deselect the given records */
		deselect: (record: TableEntry<K>) => select.deselect(getRecordKey(record)),
		/** Select records on the current page */
		selectPage,
		/** Deselect records on the current page */
		deselectPage,
		/** Toggle the selection of the given records */
		toggle: (record: TableEntry<K>) => select.toggle(getRecordKey(record)),
		/** Determine if the given record is selected */
		selected: (record: TableEntry<K>) => select.selected(getRecordKey(record)),
		/** Select all records */
		selectAll: select.selectAll,
		/** Deselect all records */
		deselectAll: select.deselectAll,
		/** Whether all records on the current page are selected */
		isPageSelected,
		/** Determine if any records are selected */
		hasSelected: select.hasSelected,
		/** Bind the given record to a checkbox */
		bindCheckbox: (record: TableEntry<K>) => select.bind(getRecordKey(record)),
		/** Bind the select all checkbox to the current page */
		bindPage,
		/** Bind select all records to the checkbox */
		bindAll: select.bindAll,
		/** Include the sorts, filters, and search query */
		...refine,
	});
}
