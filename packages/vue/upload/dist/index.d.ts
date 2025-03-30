export declare interface ExtendedUpload extends Upload {
    extensions: string[];
    mimes: string[];
    size: number;
}

export declare interface FormAttributes {
    action: string;
    method: "POST";
    enctype: "multipart/form-data";
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

export declare interface Options<T = any> {
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

export declare interface Presign<T = any> {
    attributes: FormAttributes;
    inputs: FormInputs;
    data: T;
}

export declare interface Upload {
    multiple: boolean;
    message: string;
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

export declare type UploadStatus = "pending" | "uploading" | "completed" | "error";

export declare type UseUpload = typeof useUpload;

export declare function useUpload<T = any>(url: string, uploadOptions?: Options<T>): {
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
    upload: (file: File, options?: Omit<Options<T>, "upload" | "waited" | "files">) => Promise<void>;
    preview: (file: File | string) => string;
    dragRegion: () => {
        ondragover: (e: DragEvent) => void;
        ondrop: (e: DragEvent) => void;
        ondragleave: (e: DragEvent) => void;
    };
    bind: () => {
        type: string;
        multiple: boolean;
        onChange: (event: Event) => void;
    };
};

export { }
