import { useUpload } from "./upload";

export type * from "./types";
export type UseUpload = typeof useUpload;

export { useUpload };

export const UNITS = ["B", "KB", "MB", "GB", "TB", "PB", "EB", "ZB", "YB"];

export function fileSize(
    bytes: number,
    precision: number = 0,
    maxPrecision: number|null = null,
) {
    let i = 0;

    for (i = 0; (bytes / 1024) > 0.9 && (i < UNITS.length - 1); i++) {
        bytes /= 1024;
    }

    return `${bytes.toFixed(precision)} ${UNITS[i]}`;
}