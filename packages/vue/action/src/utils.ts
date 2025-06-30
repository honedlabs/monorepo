import type { VisitOptions } from "@inertiajs/core";
import { router } from "@inertiajs/vue3";
import type {
	MaybeEndpoint,
	MaybeId,
	OperationData,
	OperationDataMap,
} from "./types";
import { Operations } from "./operations";
import axios from "axios";

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
		const { url, method } = operation.route;

		if (operation.inertia) window.location.href = url;
		else router.visit(url, { ...options, method });

		return true;
	}

	if (!operation.action || !endpoint) {
		return false;
	}

	const payload = {
		...data,
		name: operation.name,
		type: operation.type,
	};

	if (operation.inertia) router.post(endpoint, payload, options);
	else axios.post(endpoint, payload).catch((e) => options.onError?.(e));

	return true;
}

/**
 * Execute an operation with common logic
 */
export function executor(
	operation: Operations,
	endpoint: MaybeEndpoint,
	id: MaybeId,
	data: OperationData = {},
	options: VisitOptions = {},
) {
	return execute(
		operation,
		endpoint,
		{ ...data, id: id ?? undefined },
		options,
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
	payload: OperationDataMap[T["type"]] = {} as OperationDataMap[T["type"]],
) {
	return operations.map((operation) => ({
		...operation,
		execute: (
			data: OperationDataMap[typeof operation.type] = {},
			options: VisitOptions = {},
		) =>
			executor(
				operation,
				endpoint,
				id,
				{ ...payload, ...data },
				{ ...defaults, ...options },
			),
	}));
}
