export type FlashCallback = (flash: Flash) => void;

export type FlashPluginOptions = {
	resolve: FlashCallback;
};

export type FlashType = "success" | "error" | "info" | "warning" | string;

export interface Flash {
	message: string;
	type?: FlashType;
	title?: string;
	duration?: number | null;
}
