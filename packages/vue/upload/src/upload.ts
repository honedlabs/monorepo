import { reactive, computed, ref } from "vue";
import axios from "axios";
import type {
	Options,
	UploadFile,
	UploadStatus,
	Presign,
	AsFile,
} from "./types";

export function useUpload<T = any>(
	url: string,
	uploadOptions: Options<T> = {},
) {
	if (!url) {
		throw new Error("A URL is required to use the uploader.");
	}

	/**
	 * Unique identifier for each file
	 */
	const id = ref<number>(1);

	/**
	 * Ref containing the files
	 */
	const files = ref<UploadFile[]>(
		(uploadOptions.files || []).map((file: AsFile) => {
			const identifier = id.value++;

			return {
				...file,
				id: identifier,
				status: "completed" as UploadStatus,
				remove: () => remove(identifier),
				preview: () => preview(file.source),
			};
		}),
	);

	/**
	 * Whether there are any files in the uploader.
	 */
	const hasFiles = computed(() => files.value.length > 0);

	/**
	 * Ref containing whether there are files being dragged.
	 */
	const dragging = ref(false);

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
			upload: function (options: Options<T> = {}) {
				const {
					onStart,
					onUploadSuccess,
					onError,
					onUploadError,
					onProgress,
					...rest
				} = options;

				upload(uploadFile.source as File, {
					onStart: function (file: File) {
						onStart?.(file);
						uploadFile.status = "uploading";
					},
					onUploadSuccess: function (data: T) {
						onUploadSuccess?.(data);
						uploadFile.status = "completed";
					},
					onError: function (error: Record<string, any>) {
						onError?.(error);
						uploadFile.status = "error";
					},
					onUploadError: function (error: Error) {
						onUploadError?.(error);
						uploadFile.status = "error";
					},
					onProgress: function (progress: number) {
						onProgress?.(progress);
						uploadFile.progress = progress;
					},
					...rest,
				});
			},
			remove: () => remove(identifier),
			preview: () => preview(uploadFile.source),
		});

		files.value.unshift(uploadFile);

		if (!uploadOptions.waited) {
			uploadFile.upload();
		}
	}

	/**
	 * Create and upload a presigned URL for the file to S3.
	 */
	async function upload(
		file: File,
		options: Omit<Options<T>, "upload" | "waited" | "files"> = {},
	) {
		function onEvent<K extends any = any>(
			event: keyof Omit<Options<T>, "upload" | "waited" | "meta" | "files">,
			arg?: K,
		) {
			(uploadOptions?.[event] as ((arg?: K) => void) | undefined)?.(arg);
			(options?.[event] as ((arg?: K) => void) | undefined)?.(arg);
		}

		onEvent<File>("onStart", file);

		axios
			.post(url, {
				name: file.name,
				size: file.size,
				type: file.type,
				meta: { ...uploadOptions.meta, ...options.meta },
			})
			.then(({ data }: { data: Presign<T> }) => {
				onEvent<T>("onSuccess", data.data);

				const formData = new FormData();

				Object.entries(data.inputs).forEach(([key, value]) =>
					formData.append(key, value as string),
				);

				formData.append("Content-Type", file.type);
				formData.append("file", file);

				axios
					.post(data.attributes.action, formData, {
						onUploadProgress: (event) => {
							if (event.total) {
								const progress = Math.round((event.loaded * 100) / event.total);
								onEvent<number>("onProgress", progress);
							}
						},
					})
					.then(({ data }) => onEvent<T>("onUploadSuccess", data.data))
					.catch((error: Error) => onEvent<Error>("onUploadError", error));
			})
			.catch((error) => {
				Object.assign(errors, error?.response?.data);

				onEvent<Record<string, any>>("onError", error);
			})
			.finally(() => onEvent("onFinish"));
	}

	/**
	 * Remove a single file by the identifier.
	 */
	function remove(identifier: number) {
		const index = files.value.findIndex(
			({ id }: { id: number }) => id === identifier,
		);

		if (index === -1) return;

		const [file] = files.value.splice(index, 1);

		uploadOptions.onRemove?.(file);
	}

	/**
	 * Remove all files.
	 */
	function clear() {
		files.value = [];
	}

	/**
	 * Collect files from a clipboard paste event.
	 */
	function clipboardFiles(
		clipboardData: DataTransfer | null | undefined,
	): File[] {
		if (!clipboardData) {
			return [];
		}

		const fromFiles = Array.from(clipboardData.files || []);

		if (fromFiles.length) {
			return fromFiles;
		}

		return Array.from(clipboardData.items || [])
			.filter((item) => item.kind === "file")
			.map((item) => item.getAsFile())
			.filter((file): file is File => file !== null);
	}

	/**
	 * Bind a region to be the drag, drop, and paste zone.
	 */
	function dragRegion() {
		return {
			tabindex: 0,
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
			onpaste: (e: ClipboardEvent) => {
				const files = clipboardFiles(e.clipboardData);

				if (!files.length) {
					return;
				}

				e.preventDefault();
				addFiles(files);
			},
		};
	}

	/**
	 * Bind the input to a form input.
	 */
	function bind() {
		return {
			type: "file",
			multiple: uploadOptions.upload?.multiple ?? false,
			onChange: (event: Event) => {
				const input = event.target as HTMLInputElement;
				addFiles(Array.from(input.files || []));
			},
		};
	}

	/**
	 * Create a displayable URL for the file.
	 */
	function preview(file: File | string | undefined | null) {
		if (!file || typeof file === "string") {
			return file;
		}

		try {
			return URL.createObjectURL(file);
		} catch (error) {
			return null;
		}
	}

	return reactive({
		files,
		hasFiles,
		dragging,
		errors,
		hasErrors,
		addFiles,
		add,
		remove,
		clear,
		upload,
		preview,
		dragRegion,
		bind,
	});
}
