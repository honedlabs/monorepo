import { useTable } from "./table";

export type {
	Identifier,
	Config,
	PaginatorKind,
	PaginatorLink,
	CollectionPaginator,
	CursorPaginator,
	SimplePaginator,
	LengthAwarePaginator,
	PerPageRecord,
	Column,
	AsRecord,
	Table,
	TableRecord,
	TableHeading,
	TableColumn,
	TableOptions,
} from "./types";
export { useTable };

export type UseTable = typeof useTable;
