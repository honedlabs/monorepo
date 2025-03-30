import { ref as m, reactive as g, computed as j } from "vue";
import E from "axios";
function R(v, o = {}) {
  if (!v)
    throw new Error("A URL is required to use the uploader.");
  const p = m(1), u = m(
    (o.files || []).map((e, r) => ({
      ...e,
      id: p.value++,
      remove: () => l(r)
    }))
  ), f = m(!1), i = g({}), U = j(() => Object.keys(i).length > 0);
  function d(e) {
    e.forEach((r) => {
      h(r);
    });
  }
  function h(e) {
    const r = p.value++, t = g({
      id: r,
      name: e.name,
      size: e.size,
      type: e.type,
      extension: e.name.split(".").pop(),
      progress: 0,
      status: "pending",
      source: e,
      upload: () => {
        y(t.source, {
          onStart: () => t.status = "uploading",
          onUploadSuccess: () => t.status = "completed",
          onError: () => t.status = "error",
          onUploadError: () => t.status = "error",
          onProgress: (n) => t.progress = n
        });
      },
      remove: () => l(r)
    });
    u.value.unshift(t), o.waited || t.upload();
  }
  async function y(e, r = {}) {
    function t(n, s) {
      var a, c;
      (a = o == null ? void 0 : o[n]) == null || a.call(o, s), (c = r == null ? void 0 : r[n]) == null || c.call(r, s);
    }
    t("onStart", e), E.post(v, {
      name: e.name,
      size: e.size,
      type: e.type,
      meta: { ...o.meta, ...r.meta }
    }).then(({ data: n }) => {
      t("onSuccess", n.data);
      const s = new FormData();
      Object.entries(n.inputs).forEach(
        ([a, c]) => s.append(a, c)
      ), s.append("file", e), E.post(n.attributes.action, s, {
        onUploadProgress: (a) => {
          if (a.total) {
            const c = Math.round(a.loaded * 100 / a.total);
            t("onProgress", c);
          }
        }
      }).then(({ data: a }) => t("onUploadSuccess", a.data)).catch((a) => t("onUploadError", a));
    }).catch((n) => {
      Object.assign(i, n.response.data), t("onError", n);
    }).finally(() => t("onFinish"));
  }
  function l(e) {
    u.value = u.value.filter(({ id: r }) => r !== e);
  }
  function b() {
    u.value = [];
  }
  function w() {
    return {
      ondragover: (e) => {
        e.preventDefault(), f.value = !0;
      },
      ondrop: (e) => {
        var r;
        e.preventDefault(), d(Array.from(((r = e.dataTransfer) == null ? void 0 : r.files) || [])), f.value = !1;
      },
      ondragleave: (e) => {
        e.preventDefault(), f.value = !1;
      }
    };
  }
  function D() {
    var e;
    return {
      type: "file",
      multiple: ((e = o.upload) == null ? void 0 : e.multiple) ?? !1,
      onChange: (r) => {
        const t = r.target;
        d(Array.from(t.files || []));
      }
    };
  }
  function S(e) {
    return typeof e == "string" ? e : URL.createObjectURL(e);
  }
  return g({
    files: u,
    dragging: f,
    errors: i,
    hasErrors: U,
    addFiles: d,
    add: h,
    remove: l,
    clear: b,
    upload: y,
    preview: S,
    dragRegion: w,
    bind: D
  });
}
export {
  R as useUpload
};
