export declare interface BindingOptions {
    accept?: string[];
    multiple?: boolean;
}

export declare interface FormAttributes {
    action: string;
    method: "POST";
    enctype: "multipart/form-data";
}

export declare interface FormInputBinding {
    multiple: boolean;
    accept: string[];
}

export declare interface FormInputs {
    acl: string;
    key: string;
    "X-Amz-Credential": string;
    "X-Amz-Algorithm": string;
    "X-Amz-Date": string;
    Policy: string;
    "X-Amz-Signature": string;
}

export declare interface PresignedResponse {
    attributes: FormAttributes;
    inputs: FormInputs;
}

export declare interface UploadFile {
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

export declare interface UploadOptions {
    waited?: boolean;
    meta?: Record<string, any>;
    files?: UploadFile[];
    onStart?: (file: File) => void;
    onError?: (error: any) => void;
    onPresign?: (data: any) => void;
    onInvalid?: (error: any) => void;
    onSuccess?: () => void;
    onFinish?: () => void;
    onProgress?: (progress: number) => void;
}

export declare type UploadStatus = "pending" | "uploading" | "completed" | "error";

export declare const useUpload: (url: string, defaultOptions?: UploadOptions) => {
    files: {
        id: number;
        name: string;
        size?: number | undefined;
        type?: string | undefined;
        extension?: string | undefined;
        progress?: number | undefined;
        status?: UploadStatus | undefined;
        source: string | {
            readonly lastModified: number;
            readonly name: string;
            readonly webkitRelativePath: string;
            readonly size: number;
            readonly type: string;
            arrayBuffer: () => Promise<ArrayBuffer>;
            slice: (start?: number | undefined, end?: number | undefined, contentType?: string | undefined) => Blob;
            stream: () => ReadableStream<Uint8Array>;
            text: () => Promise<string>;
        };
        remove: () => void;
        upload?: (() => void) | undefined;
    }[];
    dragging: boolean;
    errors: Record<string, string[]>;
    hasErrors: boolean;
    addFiles: (files: File[]) => void;
    add: (file: File) => void;
    remove: (identifier: number) => void;
    clear: () => void;
    upload: (file: File, options?: Omit<UploadOptions, "waited" | "files">) => Promise<void>;
    toSource: (file: File | string) => string;
    bindInput: () => {
        type: string;
        multiple: boolean;
        onChange: (event: Event) => void;
    };
    bindDrag: () => {
        ondragover: (e: DragEvent) => void;
        ondrop: (e: DragEvent) => void;
        ondragleave: (e: DragEvent) => void;
    };
};

export { }
