import type { VisitOptions } from "@inertiajs/core";
import { router } from "@inertiajs/vue3";
import type {
	InlineOperation,
	BulkOperation,
	PageOperation,
	MaybeEndpoint,
	MaybeId,
	OperationData,
	OperationDataMap,
} from "./types";
import { Operations } from "./operations";

/**
 * Execute an operation with full type safety.
 */
export function execute<T extends Operations>(
	operation: T,
	endpoint: string | null | undefined,
	data: OperationDataMap[typeof operation.type],
	options: VisitOptions = {},
): boolean {
	if (operation.route) {
		router.visit(operation.route.url, {
			...options,
			method: operation.route.method,
		});
		return true;
	}

	if (operation.action && endpoint) {
		router.post(
			endpoint,
			{
				...data,
				name: operation.name,
				type: operation.type,
			},
			options,
		);
		return true;
	}

	return false;
}

/**
 * Execute an operation with common logic
 */
export function executor(
	operation: InlineOperation | BulkOperation | PageOperation,
	endpoint: MaybeEndpoint,
	id: MaybeId,
	data: OperationData = {},
	options: VisitOptions = {},
) {
	return execute(
		operation,
		endpoint,
		{
			...data,
			id: id ?? undefined,
		},
		{
			...options,
		},
	);
}

/**
 * Create operations with execute methods
 */
export function executables<T extends Operations>(
	operations: T[],
	endpoint: MaybeEndpoint,
	id: MaybeId,
	defaults: VisitOptions = {},
) {
	return operations.map((operation) => ({
		...operation,
		execute: (
			data: OperationData[typeof operation.type] = {},
			options: VisitOptions = {},
		) => executor(operation, endpoint, id, data, { ...defaults, ...options }),
	}));
}
