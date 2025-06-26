import type { VisitOptions } from "@inertiajs/core";
import { computed } from "vue";
import {
	type Batch,
	type InlineOperation,
	type InlineOperationData,
	type BulkOperation,
	type BulkOperationData,
	type PageOperation,
	type PageOperationData,
	type Operations,
	type OperationDataMap,
	type HonedBatch,
	Executable,
} from "./types";
import {
	executor as operationExecutor,
	executables as operationExecutables,
} from "./utils";

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
	 * Execute an operation with common logic
	 */
	function executor<T extends Operations>(
		operation: T,
		data: OperationDataMap[typeof operation.type] = {},
		options: VisitOptions = {},
	) {
		return operationExecutor(
			operation,
			batch.value.endpoint,
			batch.value.id,
			data,
			{ ...defaults, ...options },
		);
	}

	/**
	 * Create operations with execute methods
	 */
	function executables<T extends Operations>(operations: T[]) {
		return operationExecutables(
			operations,
			batch.value.endpoint,
			batch.value.id,
			defaults,
		);
	}

	/**
	 * Execute an inline operation
	 */
	function executeInline(
		operation: InlineOperation,
		data: InlineOperationData,
		options: VisitOptions = {},
	) {
		return executor(operation, data, options);
	}

	/**
	 * Execute a bulk operation
	 */
	function executeBulk(
		operation: BulkOperation,
		data: BulkOperationData,
		options: VisitOptions = {},
	) {
		return executor(operation, data, options);
	}

	/**
	 * Execute a page operation
	 */
	function executePage(
		operation: PageOperation,
		data: PageOperationData = {},
		options: VisitOptions = {},
	) {
		return executor(operation, data, options);
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
