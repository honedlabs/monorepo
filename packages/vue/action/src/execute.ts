import type { VisitOptions } from "@inertiajs/core";
import { router } from "@inertiajs/vue3";
import type {
	OperationType,
	InlineOperation,
	BulkOperation,
	PageOperation,
	InlineOperationData,
	BulkOperationData,
} from "./types";

type OperationMap = {
	inline: InlineOperation;
	bulk: BulkOperation;
	page: PageOperation;
};

type DataMap = {
	inline: InlineOperationData;
	bulk: BulkOperationData;
	page: Record<string, any>;
};

/**
 * Execute an operation with full type safety.
 */
export function executeOperation<T extends OperationType>(
	action: OperationMap[T],
	endpoint?: string,
	data: DataMap[T] = {} as DataMap[T],
	options: VisitOptions = {},
): boolean {
	if (action.route) {
		router.visit(action.route.url, {
			...options,
			method: action.route.method,
		});
		return true;
	}

	if (action.action && endpoint) {
		router.post(
			endpoint,
			{
				...data,
				name: action.name,
				type: action.type,
			},
			options,
		);
		return true;
	}

	return false;
}
