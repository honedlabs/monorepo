import type { VisitOptions } from "@inertiajs/core";
import { computed, reactive } from "vue";
import type {
	Batch,
	InlineOperation,
	InlineOperationData,
	BulkOperation,
	BulkOperationData,
	PageOperation,
} from "./types";
import { executeOperation } from "./execute";

export function useBatch<T extends Record<string, Batch>>(
	props: T,
	key: keyof T,
	defaults: VisitOptions = {},
) {
	if (!props?.[key]) {
		throw new Error(
			"The operation group must be provided with valid props and key.",
		);
	}

	const batch = computed(() => props[key]);

	/**
	 * Execute an operation with common logic
	 */
	function executor(
		operation: InlineOperation | BulkOperation | PageOperation,
		data: InlineOperationData | BulkOperationData | Record<string, any> = {},
		options: VisitOptions = {},
	) {
		executeOperation(
			operation,
			batch.value.endpoint,
			{
				...data,
				id: batch.value.id,
			},
			{
				...defaults,
				...options,
			},
		);
	}

	/**
	 * Create operations with execute methods
	 */
	function createOperationsWithExecute<
		T extends InlineOperation | BulkOperation | PageOperation,
	>(operations: T[]) {
		return operations.map((operation) => ({
			...operation,
			execute: (
				data: T extends InlineOperation
					? InlineOperationData
					: T extends BulkOperation
						? BulkOperationData
						: Record<string, any> = {} as any,
				options: VisitOptions = {},
			) => executor(operation, data, options),
		}));
	}

	const inline = computed(() =>
		createOperationsWithExecute(batch.value.inline),
	);

	const bulk = computed(() => createOperationsWithExecute(batch.value.bulk));

	const page = computed(() => createOperationsWithExecute(batch.value.page));

	function executeInline(
		operation: InlineOperation,
		data: InlineOperationData,
		options: VisitOptions = {},
	) {
		executor(operation, data, options);
	}

	function executeBulk(
		operation: BulkOperation,
		data: BulkOperationData,
		options: VisitOptions = {},
	) {
		executor(operation, data, options);
	}

	function executePage(
		operation: PageOperation,
		data: Record<string, any> = {},
		options: VisitOptions = {},
	) {
		executor(operation, data, options);
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
