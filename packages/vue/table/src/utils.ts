import { ColumnType } from "./columns";
import { Column } from "./types";

export function is(column: Column|string|null|undefined, type: ColumnType) {
    if (!column)
        return false

    if (typeof column === "object")
        return column.type === type

    return column === type
}