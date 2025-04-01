import { useActions } from "./action";
import { useBulk } from "./bulk";

export type { BulkSelection } from "./bulk";
export type * from "./action";

export { executeAction } from "./action";

export type UseActions = typeof useActions;
export type UseBulk = typeof useBulk;

export { useActions, useBulk };
