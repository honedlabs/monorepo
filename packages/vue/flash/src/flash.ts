import { resolver } from "./resolver";
import type { Flash, FlashType } from "./types";

function normalise(message: Flash | string): Flash {
	return typeof message === "string" ? { message } : message;
}

export function flash(type?: FlashType) {
	return (message: Flash | string) => {
		const flash = normalise(message);

		resolver.resolve(type ? { ...flash, type } : flash);
	};
}

export function success() {
	return flash("success");
}

export function error() {
	return flash("error");
}

export function info() {
	return flash("info");
}

export function warning() {
	return flash("warning");
}

export function useFlash() {
	return {
		flash,
		success,
		error,
		info,
		warning,
	};
}
