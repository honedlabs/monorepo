export interface Upload {
    multiple: boolean;
    message: string;
}

export interface ExtendedUpload extends Upload {
    extensions: string[];
    mimes: string[];
    size: number;
}

export type UploadStatus = "pending" | "uploading" | "completed" | "error";

export interface UploadFile {
	id: number;
	name: string;
	size?: number;
	type?: string;
	extension?: string;
	progress?: number;
	status?: UploadStatus;
	source: File | string;
	remove: () => void;
	upload?: () => void;
}

export interface Options<T = any> {
    upload?: Upload | ExtendedUpload;
	waited?: boolean;
	meta?: Record<string, any>;
	files?: UploadFile[];
	onStart?: (file: File) => void;
	onError?: (error: Record<string, any>) => void;
	onSuccess?: (data: T) => void;
	onProgress?: (progress: number) => void;
	onUploadError?: (error: Error) => void;
	onUploadSuccess?: (data: T) => void;
	onFinish?: () => void;
}

export interface FormAttributes {
	action: string;
	method: "POST";
	enctype: "multipart/form-data";
}

export interface FormInputs {
	acl: string;
	key: string;
	"X-Amz-Credential": string;
	"X-Amz-Algorithm": string;
	"X-Amz-Date": string;
	Policy: string;
	"X-Amz-Signature": string;
}

export interface Presign<T = any> {
	attributes: FormAttributes;
	inputs: FormInputs;
	data: T;
}