import { reactive, computed, ref } from "vue";
import axios from "axios";

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

export interface UploadOptions {
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

export interface BindingOptions {
	accept?: string[];
	multiple?: boolean;
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

export interface PresignedResponse {
	attributes: FormAttributes;
	inputs: FormInputs;
}

export interface FormInputBinding {
	multiple: boolean;
	accept: string[];
}

export const useUpload = (url: string, defaultOptions: UploadOptions = {}) => {
	/**
	 * Unique identifier for each file
	 */
	const id = ref<number>(1);

	/**
	 * Ref containing the files
	 */
	const files = ref<UploadFile[]>(
		(defaultOptions.files || []).map((file, i) => ({
			...file,
			id: id.value++,
			remove: () => remove(i),
		})),
	);

	/**
	 * Ref containing whether there are files being dragged.
	 */
	const dragging = ref<boolean>(false);

	/**
	 * Server validation errors.
	 */
	const errors = reactive<Record<string, string[]>>({});

	/**
	 * Whether there are any server validation errors.
	 */
	const hasErrors = computed(() => Object.keys(errors).length > 0);

	/**
	 * Add raw files to the uploader.
	 */
	function addFiles(files: File[]) {
		files.forEach((file) => {
			add(file);
		});
	}

	/**
	 * Add a file to the uploader.
	 */
	function add(file: File) {
		const identifier = id.value++;

		const uploadFile = reactive({
			id: identifier,
			name: file.name,
			size: file.size,
			type: file.type,
			extension: file.name.split(".").pop(),
			progress: 0,
			status: "pending" as UploadStatus,
			source: file,
			upload: () => {
				upload(uploadFile.source as File, {
					onStart: () => (uploadFile.status = "uploading"),
					onSuccess: () => (uploadFile.status = "completed"),
					onError: () => (uploadFile.status = "error"),
					onInvalid: () => (uploadFile.status = "error"),
					onProgress: (progress: number) => (uploadFile.progress = progress),
				});
			},
			remove: () => remove(identifier),
		});

		files.value.unshift(uploadFile);

		if (!defaultOptions.waited) {
			uploadFile.upload();
		}
	}

	/**
	 * Create and upload a presigned URL for the file to S3.
	 */
	async function upload(
		file: File,
		options: Omit<UploadOptions, "waited" | "files"> = {},
	) {
		const onEvent = (
			event: keyof Omit<UploadOptions, "waited" | "meta" | "files">,
			arg?: any,
		) => {
			defaultOptions?.[event]?.(arg);
			options?.[event]?.(arg);
		};

		onEvent("onStart", file);

		axios
			.post(url, {
				name: file.name,
				size: file.size,
				type: file.type,
				meta: { ...defaultOptions.meta, ...options.meta },
			})
			.then(({ data }: { data: PresignedResponse }) => {
				onEvent("onPresign", data);

				const formData = new FormData();

				Object.entries(data.inputs).forEach(([key, value]) =>
					formData.append(key, value as string),
				);

				formData.append("file", file);

				axios
					.post(data.attributes.action, formData, {
						onUploadProgress: (event) => {
							if (event.total) {
								const progress = Math.round((event.loaded * 100) / event.total);
								onEvent("onProgress", progress);
							}
						},
					})
					.then(({ data }) => onEvent("onSuccess", data))
					.catch((error) => onEvent("onError", error));
			})
			.catch((error) => {
				Object.assign(errors, error.response.data);

				onEvent("onInvalid", error);
			})
			.finally(() => onEvent("onFinish"));
	}

	/**
	 * Remove a single file by the identifier.
	 */
	function remove(identifier: number) {
		files.value = files.value.filter(({ id }) => id !== identifier);
	}

	/**
	 * Remove all files.
	 */
	function clear() {
		files.value = [];
	}

	/**
	 * Bind a region to be the drag and drop zone.
	 */
	function bindDrag() {
		return {
			ondragover: (e: DragEvent) => {
				e.preventDefault();
				dragging.value = true;
			},
			ondrop: (e: DragEvent) => {
				e.preventDefault();
				addFiles(Array.from(e.dataTransfer?.files || []));
				dragging.value = false;
			},
			ondragleave: (e: DragEvent) => {
				e.preventDefault();
				dragging.value = false;
			},
		};
	}

	/**
	 * Bind the input to the uploader.
	 */
	function bindInput() {
		return {
			type: "file",
			multiple: false,
			onChange: (event: Event) => {
				const input = event.target as HTMLInputElement;
				addFiles(Array.from(input.files || []));
			},
		};
	}

	/**
	 * Create a displayable URL for the file.
	 */
	function toSource(file: File | string) {
		if (typeof file === "string") {
			return file;
		}

		return URL.createObjectURL(file);
	}

	return reactive({
		files,
		dragging,
		errors,
		hasErrors,
		addFiles,
		add,
		remove,
		clear,
		upload,
		toSource,
		bindInput,
		bindDrag,
	});
};
