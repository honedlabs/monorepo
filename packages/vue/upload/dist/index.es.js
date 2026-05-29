import { computed as e, reactive as t, ref as n } from "vue";
import r from "axios";
//#region src/upload.ts
function i(i, a = {}) {
	if (!i) throw Error("A URL is required to use the uploader.");
	let o = n(1), s = n((a.files || []).map((e, t) => ({
		...e,
		id: o.value++,
		remove: () => m(t)
	}))), c = n(!1), l = t({}), u = e(() => Object.keys(l).length > 0);
	function d(e) {
		e.forEach((e) => {
			f(e);
		});
	}
	function f(e) {
		let n = o.value++, r = t({
			id: n,
			name: e.name,
			size: e.size,
			type: e.type,
			extension: e.name.split(".").pop(),
			progress: 0,
			status: "pending",
			source: e,
			upload: () => {
				p(r.source, {
					onStart: () => r.status = "uploading",
					onUploadSuccess: () => r.status = "completed",
					onError: () => r.status = "error",
					onUploadError: () => r.status = "error",
					onProgress: (e) => r.progress = e
				});
			},
			remove: () => m(n)
		});
		s.value.unshift(r), a.waited || r.upload();
	}
	async function p(e, t = {}) {
		function n(e, n) {
			a?.[e]?.(n), t?.[e]?.(n);
		}
		n("onStart", e), r.post(i, {
			name: e.name,
			size: e.size,
			type: e.type,
			meta: {
				...a.meta,
				...t.meta
			}
		}).then(({ data: t }) => {
			n("onSuccess", t.data);
			let i = new FormData();
			Object.entries(t.inputs).forEach(([e, t]) => i.append(e, t)), i.append("file", e), r.post(t.attributes.action, i, { onUploadProgress: (e) => {
				e.total && n("onProgress", Math.round(e.loaded * 100 / e.total));
			} }).then(({ data: e }) => n("onUploadSuccess", e.data)).catch((e) => n("onUploadError", e));
		}).catch((e) => {
			Object.assign(l, e.response.data), n("onError", e);
		}).finally(() => n("onFinish"));
	}
	function m(e) {
		s.value = s.value.filter(({ id: t }) => t !== e);
	}
	function h() {
		s.value = [];
	}
	function g() {
		return {
			ondragover: (e) => {
				e.preventDefault(), c.value = !0;
			},
			ondrop: (e) => {
				e.preventDefault(), d(Array.from(e.dataTransfer?.files || [])), c.value = !1;
			},
			ondragleave: (e) => {
				e.preventDefault(), c.value = !1;
			}
		};
	}
	function _() {
		return {
			type: "file",
			multiple: a.upload?.multiple ?? !1,
			onChange: (e) => {
				let t = e.target;
				d(Array.from(t.files || []));
			}
		};
	}
	function v(e) {
		return typeof e == "string" ? e : URL.createObjectURL(e);
	}
	return t({
		files: s,
		dragging: c,
		errors: l,
		hasErrors: u,
		addFiles: d,
		add: f,
		remove: m,
		clear: h,
		upload: p,
		preview: v,
		dragRegion: g,
		bind: _
	});
}
//#endregion
//#region src/index.ts
var a = [
	"B",
	"KB",
	"MB",
	"GB",
	"TB",
	"PB",
	"EB",
	"ZB",
	"YB"
];
function o(e, t = 0, n = null) {
	let r = 0;
	for (r = 0; e / 1024 > .9 && r < a.length - 1; r++) e /= 1024;
	return `${e.toFixed(t)} ${a[r]}`;
}
//#endregion
export { a as UNITS, o as fileSize, i as useUpload };
