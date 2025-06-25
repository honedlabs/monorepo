import type { VisitOptions } from "@inertiajs/core";
import { computed, reactive } from "vue";
import type {
	Batch,
	InlineOperation,
	InlineOperationData,
	BulkOperation,
	BulkOperationData,
	PageOperation,
	PageOperationData,
	Operations,
} from "./types";
import {
	executor as operationExecutor,
	executables as operationExecutables,
} from "./utils";

export function useBatch<T extends Record<string, Batch>>(
	props: T,
	key: keyof T,
	defaults: VisitOptions = {},
) {
	if (!props?.[key]) {
		throw new Error("The batch must be provided with valid props and key.");
	}

	const batch = computed(() => props[key]);

	const inline = computed(() => executables(batch.value.inline));

	const bulk = computed(() => executables(batch.value.bulk));

	const page = computed(() => executables(batch.value.page));

	/**
	 * Execute an operation with common logic
	 */
	function executor(
		operation: Operations,
		data: InlineOperationData | BulkOperationData | Record<string, any> = {},
		options: VisitOptions = {},
	) {
		return operationExecutor(
			operation,
			batch.value.endpoint,
			batch.value.id,
			data,
			{
				...defaults,
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
			batch.value.endpoint,
			batch.value.id,
			defaults,
		);
	}

	function executeInline(
		operation: InlineOperation,
		data: InlineOperationData,
		options: VisitOptions = {},
	) {
		return executor(operation, data, options);
	}

	function executeBulk(
		operation: BulkOperation,
		data: BulkOperationData,
		options: VisitOptions = {},
	) {
		return executor(operation, data, options);
	}

	function executePage(
		operation: PageOperation,
		data: PageOperationData = {},
		options: VisitOptions = {},
	) {
		return executor(operation, data, options);
	}

	return reactive({
		inline,
		bulk,
		page,
		executeInline,
		executeBulk,
		executePage,
	});
}
