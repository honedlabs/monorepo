import type { VisitOptions } from "@inertiajs/core";
import { computed } from "vue";
import type {
	Batch,
	InlineOperation,
	InlineOperationData,
	BulkOperation,
	BulkOperationData,
	PageOperation,
	PageOperationData,
	HonedBatch,
	Executable,
} from "./types";
import { executables, execute } from "./utils";

export function useBatch<T extends Record<string, Batch>>(
	props: T,
	key: keyof T,
	defaults: VisitOptions = {},
): HonedBatch {
	if (!props?.[key]) {
		throw new Error("The batch must be provided with valid props and key.");
	}

	/**
	 * The batch of operations.
	 */
	const batch = computed<Batch>(() => props[key]);

	/**
	 * The inline operations available.
	 */
	const inline = computed<Executable<InlineOperation>[]>(() =>
		executables(batch.value.inline),
	);

	/**
	 * The bulk operations available.
	 */
	const bulk = computed<Executable<BulkOperation>[]>(() =>
		executables(batch.value.bulk),
	);

	/**
	 * The page operations available.
	 */
	const page = computed<Executable<PageOperation>[]>(() =>
		executables(batch.value.page),
	);

	/**
	 * Execute an inline operation
	 */
	function executeInline(
		operation: InlineOperation,
		data: InlineOperationData,
		options: VisitOptions = {},
	) {
		return execute(operation, data, { ...defaults, ...options });
	}

	/**
	 * Execute a bulk operation
	 */
	function executeBulk(
		operation: BulkOperation,
		data: BulkOperationData,
		options: VisitOptions = {},
	) {
		return execute(operation, data, { ...defaults, ...options });
	}

	/**
	 * Execute a page operation
	 */
	function executePage(
		operation: PageOperation,
		data: PageOperationData = {},
		options: VisitOptions = {},
	) {
		return execute(operation, data, { ...defaults, ...options });
	}

	return {
		inline,
		bulk,
		page,
		executeInline,
		executeBulk,
		executePage,
	};
}
