import type {
	OperationType,
	Confirm,
	Operation,
	InlineOperation,
	BulkOperation,
	PageOperation,
    Operations,
} from "./operations";

export type Identifier = string | number;

export interface Batch {
	id?: string;
	endpoint?: string;
	inline: InlineOperation[];
	bulk: BulkOperation[];
	page: PageOperation[];
}

export interface InlineOperationData extends Record<string, any> {
	record: Identifier;
}

export interface BulkOperationData extends Record<string, any> {
	all: boolean;
	only: Identifier[];
	except: Identifier[];
}

export interface PageOperationData extends Record<string, any> {}

export type OperationData =
	| InlineOperationData
	| BulkOperationData
	| PageOperationData;

export type MaybeEndpoint = string | null | undefined;

export type MaybeId = string | null | undefined;

export type OperationMap = {
	inline: InlineOperation;
	bulk: BulkOperation;
	page: PageOperation;
};

export type OperationDataMap = {
	inline: InlineOperationData;
	bulk: BulkOperationData;
	page: PageOperationData
};

export type {
	OperationType,
	Confirm,
	Operation,
	InlineOperation,
	BulkOperation,
	PageOperation,
    Operations,
};
