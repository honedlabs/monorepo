import type { VisitOptions } from "@inertiajs/core";
import { router } from "@inertiajs/vue3";
import type { OperationData } from "./types";
import { Operations } from "./operations";
import axios from "axios";

/**
 * Execute an operation with full type safety.
 */
export function execute<T extends Operations>(
	operation: T,
	data: OperationData<T> = {} as OperationData<T>,
	options: VisitOptions = {},
): boolean {
	if (!operation.href || !operation.method) {
		return false;
	}

	console.log(options);

	if (operation.type === "inertia") {
		if (operation.method === "delete") router.delete(operation.href, options);
		else router[operation.method](operation.href, data, options);
	} else {
		const handler = (error: any) => options.onError?.(error);

		if (operation.method === "get") window.location.href = operation.href;
		else if (operation.method === "delete")
			axios.delete(operation.href).catch(handler);
		else axios[operation.method](operation.href, data).catch(handler);
	}

	return true;
}

/**
 * Create operations with execute methods
 */
export function executables<T extends Operations>(
	operations: T[],
	defaults: VisitOptions = {},
	payload: OperationData<T> = {} as OperationData<T>,
) {
	return operations.map((operation) => ({
		...operation,
		execute: (
			data: OperationData<T> = {} as OperationData<T>,
			options: VisitOptions = {},
		) =>
			execute(operation, { ...payload, ...data }, { ...defaults, ...options }),
	}));
}
