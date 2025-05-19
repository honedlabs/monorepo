import { computed, reactive } from "vue";
import type { Page, VisitOptions } from "@inertiajs/core";
import { router } from "@inertiajs/vue3";
import { useBulk, executeAction } from "@honed/action";
import type { InlineAction, BulkAction, PageAction } from "@honed/action";
import { useRefine } from "@honed/refine";
import type { Refine } from "@honed/refine";
import type {
	Identifier,
	PaginatorKind,
	PerPageRecord,
	Column,
	AsRecord,
	Table,
	TableOptions,
} from "./types";

export function useTable<
	Props extends object,
	Key extends Props[keyof Props] extends Refine ? keyof Props : never,
	RecordType extends Record<string, any> = any,
	Paginator extends PaginatorKind = "length-aware",
>(
	props: Props,
	key: Key,
	tableOptions: TableOptions<RecordType> = {},
	defaultOptions: VisitOptions = {},
) {
	if (!props || !key || !props[key]) {
		throw new Error("Table has not been provided with valid props and key.");
	}

	defaultOptions = {
		...defaultOptions,
		only: [...((defaultOptions.only ?? []) as string[]), key.toString()],
	};

	const table = computed(() => props[key] as Table<RecordType, Paginator>);
	const bulk = useBulk<Identifier>();
	const refine = useRefine<Props, Key>(props, key, defaultOptions);
	const config = computed(() => table.value.config);

	/**
	 * The metadata for the table.
	 */
	const meta = computed(() => table.value.meta);

	/**
	 * The heading columns for the table.
	 */
	const headings = computed(
		() =>
			table.value.columns
				?.filter(({ active, hidden }) => active && !hidden)
				.map((column) => ({
					...column,
					isSorting: column.sort?.active,
					toggleSort: (options: VisitOptions = {}) => sort(column, options),
				})) ?? [],
	);

	/**
	 * All of the table's columns
	 */
	const columns = computed(
		() =>
			table.value.columns
				?.filter(({ hidden }) => !hidden)
				.map((column) => ({
					...column,
					toggle: (options: VisitOptions = {}) => toggle(column, options),
				})) ?? [],
	);

	/**
	 * The records of the table.
	 */
	const records = computed(() =>
		table.value.records.map((record) => ({
			record: (({ actions, ...rest }) => rest)(record),
			/** The actions available for the record */
			actions: record.actions.map((action: InlineAction) => ({
				...action,
				/** Executes this action */
				execute: (options: VisitOptions = {}) =>
					executeInlineAction(action, record, options),
			})),
			/** Perform this action when the record is clicked */
			default: (options: VisitOptions = {}) => {
				const defaultAction = record.actions.find(
					(action: InlineAction) => action.default,
				);

				if (defaultAction) {
					executeInlineAction(defaultAction, record, options);
				}
			},
			/** Selects this record */
			select: () => bulk.select(getRecordKey(record)),
			/** Deselects this record */
			deselect: () => bulk.deselect(getRecordKey(record)),
			/** Toggles the selection of this record */
			toggle: () => bulk.toggle(getRecordKey(record)),
			/** Determine if the record is selected */
			selected: bulk.selected(getRecordKey(record)),
			/** Bind the record to a checkbox */
			bind: () => bulk.bind(getRecordKey(record)),
			/** Get the value of the record for the column */
			value: (column: Column<RecordType> | string) => {
				const name = getColumnName(column);
				return name in record ? record[name].value : null;
			},
			/** Get the extra data of the record for the column */
			extra: (column: Column<RecordType> | string) => {
				const name = getColumnName(column);
				return name in record ? record[name].extra : null;
			},
		})),
	);

	/**
	 * Get the bulk actions.
	 */
	const bulkActions = computed(() =>
		table.value.actions.bulk.map((action) => ({
			...action,
			execute: (options: VisitOptions = {}) =>
				executeBulkAction(action, options),
		})),
	);

	/**
	 * Get page actions.
	 */
	const pageActions = computed(() =>
		table.value.actions.page.map((action) => ({
			...action,
			execute: (options: VisitOptions = {}) =>
				executePageAction(action, options),
		})),
	);

	/**
	 * Available number of records to display per page.
	 */
	const rowsPerPage = computed(
		() =>
			table.value.recordsPerPage?.map((page) => ({
				...page,
				apply: (options: VisitOptions = {}) => applyPage(page, options),
			})) ?? [],
	);

	/**
	 * The current number of records to display per page.
	 */
	const currentPage = computed(() =>
		table.value.recordsPerPage?.find(({ active }) => active),
	);

	/**
	 * The paginator metadata.
	 */
	const paginator = computed(() => ({
		...table.value.paginator,
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
		...("links" in table.value.paginator && table.value.paginator.links
			? {
					links: table.value.paginator.links.map((link) => ({
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
			table.value.records.every((record: AsRecord<RecordType>) =>
				bulk.selected(getRecordKey(record)),
			),
	);

	/**
	 * Get the identifier of the record.
	 */
	function getRecordKey(record: AsRecord<RecordType>) {
		return record[config.value.key].value as Identifier;
	}

	/**
	 * Get the name of the column.
	 */
	function getColumnName(column: Column<RecordType> | string) {
		return typeof column === "string" ? column : column.name;
	}
	
	/**
	 * Visit a page.
	 */
	function toPage(link: string, options: VisitOptions = {}) {
		router.visit(link, {
			preserveScroll: true,
			preserveState: true,
			...defaultOptions,
			...options,
			method: "get",
		});
	}

	/**
	 * Execute an inline action.
	 */
	function executeInlineAction(
		action: InlineAction,
		record: AsRecord<RecordType>,
		options: VisitOptions = {},
	) {
		const success = executeAction<"inline">(
			action,
			config.value.endpoint,
			{
				id: table.value.id,
				record: getRecordKey(record),
			},
			options,
		);

		if (!success) {
			tableOptions.recordActions?.[action.name]?.(record);
		}
	}

	/**
	 * Execute a bulk action.
	 */
	function executeBulkAction(action: BulkAction, options: VisitOptions = {}) {
		executeAction<"bulk">(
			action,
			config.value.endpoint,
			{
				id: table.value.id,
				all: bulk.selection.value.all,
				only: Array.from(bulk.selection.value.only),
				except: Array.from(bulk.selection.value.except),
			},
			{
				...options,
				onSuccess: (page: Page) => {
					options.onSuccess?.(page);
					if (!action.keepSelected) {
						bulk.deselectAll();
					}
				},
			},
		);
	}

	/**
	 * Execute a page action.
	 */
	function executePageAction(action: PageAction, options: VisitOptions = {}) {
		executeAction<"page">(
			action,
			config.value.endpoint,
			{
				id: table.value.id,
			},
			options,
		);
	}

	/**
	 * Apply a new page by changing the number of records to display.
	 */
	function applyPage(page: PerPageRecord, options: VisitOptions = {}) {
		router.reload({
			...defaultOptions,
			...options,
			data: {
				[config.value.record]: page.value,
				[config.value.page]: undefined,
			},
		});
	}

	/**
	 * Apply a column sort.
	 */
	function sort(column: Column<RecordType>, options: VisitOptions = {}) {
		if (!column.sort) {
			return;
		}

		router.reload({
			...defaultOptions,
			...options,
			data: {
				[config.value.sort]: refine.omitValue(column.sort.next),
			},
		});
	}

	/**
	 * Toggle a column's visibility.
	 */
	function toggle(column: Column<RecordType>, options: VisitOptions = {}) {
		const params = refine.toggleValue(
			column.name,
			headings.value.map(({ name }) => name),
		);

		router.reload({
			...defaultOptions,
			...options,
			data: {
				[config.value.column]: refine.delimitArray(params),
			},
		});
	}

	/**
	 * Selects records on the current page.
	 */
	function selectPage() {
		bulk.select(
			...table.value.records.map((record: AsRecord<RecordType>) =>
				getRecordKey(record),
			),
		);
	}

	/**
	 * Deselects records on the current page.
	 */
	function deselectPage() {
		bulk.deselect(
			...table.value.records.map((record: AsRecord<RecordType>) =>
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
				if (checked) {
					selectPage();
				} else {
					deselectPage();
				}
			},
			modelValue: isPageSelected.value,
		};
	}

	return reactive({
		/** Retrieve a record's identifier */
		getRecordKey,
		/** Table-specific metadata */
		meta,
		/** The heading columns for the table */
		headings,
		/** All of the table's columns */
		columns,
		/** The records of the table */
		records,
		/** Whether the table has record actions */
		inline: table.value.actions.inline,
		/** The available bulk actions */
		bulkActions,
		/** The available page actions */
		pageActions,
		/** The available number of records to display per page */
		rowsPerPage,
		/** The current record per page item */
		currentPage,
		/** The pagination metadata */
		paginator,
		/** Execute an inline action */
		executeInlineAction,
		/** Execute a bulk action */
		executeBulkAction,
		/** Execute a page action */
		executePageAction,
		/** Apply a new page by changing the number of records to display */
		applyPage,
		/** The current selection of records */
		selection: bulk.selection,
		/** Select the given records */
		select: (record: AsRecord<RecordType>) => bulk.select(getRecordKey(record)),
		/** Deselect the given records */
		deselect: (record: AsRecord<RecordType>) =>
			bulk.deselect(getRecordKey(record)),
		/** Select records on the current page */
		selectPage,
		/** Deselect records on the current page */
		deselectPage,
		/** Toggle the selection of the given records */
		toggle: (record: AsRecord<RecordType>) => bulk.toggle(getRecordKey(record)),
		/** Determine if the given record is selected */
		selected: (record: AsRecord<RecordType>) =>
			bulk.selected(getRecordKey(record)),
		/** Select all records */
		selectAll: bulk.selectAll,
		/** Deselect all records */
		deselectAll: bulk.deselectAll,
		/** Whether all records on the current page are selected */
		isPageSelected,
		/** Determine if any records are selected */
		hasSelected: bulk.hasSelected,
		/** Bind the given record to a checkbox */
		bindCheckbox: (record: AsRecord<RecordType>) =>
			bulk.bind(getRecordKey(record)),
		/** Bind the select all checkbox to the current page */
		bindPage,
		/** Bind select all records to the checkbox */
		bindAll: bulk.bindAll,
		/** Include the sorts, filters, and search query */
		...refine,
	});
}
