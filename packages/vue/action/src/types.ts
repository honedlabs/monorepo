import type { ComputedRef } from "vue";
import type { VisitOptions } from "@inertiajs/core";
import type {
	Operation,
	InlineOperation,
	BulkOperation,
	PageOperation,
} from "./operations";

export type Identifier = string | number;

export interface InlineOperationData extends Record<string, any> {
	record: Identifier;
}

export interface BulkOperationData extends Record<string, any> {
	all: boolean;
	only: Identifier[];
	except: Identifier[];
}

export interface PageOperationData extends Record<string, any> {}

export type OperationData<T extends Operation> = T extends InlineOperation
	? InlineOperationData
	: T extends BulkOperation
		? BulkOperationData
		: PageOperationData;

export interface Batch {
	id?: string;
	endpoint?: string;
	inline: InlineOperation[];
	bulk: BulkOperation[];
	page: PageOperation[];
}

export type Executable<T extends Operation> = T & {
	execute: (data?: OperationData<T>, options?: VisitOptions) => boolean;
};

export interface HonedBatch {
	inline: ComputedRef<Executable<InlineOperation>[]>;
	bulk: ComputedRef<Executable<BulkOperation>[]>;
	page: ComputedRef<Executable<PageOperation>[]>;
	executeInline: (
		operation: InlineOperation,
		data: InlineOperationData,
		options?: VisitOptions,
	) => boolean;
	executeBulk: (
		operation: BulkOperation,
		data: BulkOperationData,
		options?: VisitOptions,
	) => boolean;
	executePage: (
		operation: PageOperation,
		data?: PageOperationData,
		options?: VisitOptions,
	) => boolean;
}

export type * from "./operations";
