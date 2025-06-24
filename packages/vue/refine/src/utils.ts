/**
 * Converts an array parameter to a comma-separated string for URL parameters.
 */
export function delimitArray(value: any, delimiter: string = ",") {
	if (Array.isArray(value)) {
		return value.join(delimiter);
	}

	return value;
}

/**
 * Formats a string value for search parameters.
 */
export function stringValue(value: any) {
	if (typeof value !== "string") {
		return value;
	}

	return value.trim().replace(/\s+/g, "+");
}

/**
 * Returns undefined if the value is an empty string, null, or undefined.
 */
export function omitValue(value: any) {
	if (["", null, undefined, []].includes(value)) {
		return undefined;
	}

	return value;
}
