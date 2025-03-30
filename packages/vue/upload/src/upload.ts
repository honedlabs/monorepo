import { reactive, computed, ref } from "vue";
import axios from "axios";
import type { Options, UploadFile, UploadStatus, Presign } from "./types";

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
		(uploadOptions.files || []).map((file, i) => ({
			...file,
			id: id.value++,
			remove: () => remove(i),
		})),
	);

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
			upload: () => {
				upload(uploadFile.source as File, {
					onStart: () => (uploadFile.status = "uploading"),
					onUploadSuccess: () => (uploadFile.status = "completed"),
					onError: () => (uploadFile.status = "error"),
					onUploadError: () => (uploadFile.status = "error"),
					onProgress: (progress: number) => (uploadFile.progress = progress),
				});
			},
			remove: () => remove(identifier),
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
				Object.assign(errors, error.response.data);

				onEvent<Record<string, any>>("onError", error);
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
	function dragRegion() {
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
	function preview(file: File | string) {
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
		preview,
		dragRegion,
		bind,
	});
}
