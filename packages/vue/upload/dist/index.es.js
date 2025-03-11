import { ref as p, reactive as g, computed as F } from "vue";
import y from "axios";
const x = (b, o = {}) => {
  const v = p(1), u = p(
    (o.files || []).map((e, r) => ({
      ...e,
      id: v.value++,
      remove: () => m(r)
    }))
  ), i = p(!1), l = g({}), D = F(() => Object.keys(l).length > 0);
  function d(e) {
    e.forEach((r) => {
      f(r);
    });
  }
  function f(e) {
    const r = v.value++, n = g({
      id: r,
      name: e.name,
      size: e.size,
      type: e.type,
      extension: e.name.split(".").pop(),
      progress: 0,
      status: "pending",
      source: e,
      upload: () => {
        h(n.source, {
          onStart: () => n.status = "uploading",
          onSuccess: () => n.status = "completed",
          onError: () => n.status = "error",
          onInvalid: () => n.status = "error",
          onProgress: (t) => n.progress = t
        });
      },
      remove: () => m(r)
    });
    u.value.unshift(n), o.waited || n.upload();
  }
  async function h(e, r = {}) {
    const n = (t, s) => {
      var a, c;
      (a = o == null ? void 0 : o[t]) == null || a.call(o, s), (c = r == null ? void 0 : r[t]) == null || c.call(r, s);
    };
    n("onStart", e), y.post(b, {
      name: e.name,
      size: e.size,
      type: e.type,
      meta: { ...o.meta, ...r.meta }
    }).then(({ data: t }) => {
      n("onPresign", t);
      const s = new FormData();
      Object.entries(t.inputs).forEach(
        ([a, c]) => s.append(a, c)
      ), s.append("file", e), y.post(t.attributes.action, s, {
        onUploadProgress: (a) => {
          if (a.total) {
            const c = Math.round(a.loaded * 100 / a.total);
            n("onProgress", c);
          }
        }
      }).then(({ data: a }) => n("onSuccess", a)).catch((a) => n("onError", a));
    }).catch((t) => {
      Object.assign(l, t.response.data), n("onInvalid", t);
    }).finally(() => n("onFinish"));
  }
  function m(e) {
    u.value = u.value.filter(({ id: r }) => r !== e);
  }
  function E() {
    u.value = [];
  }
  function S() {
    return {
      ondragover: (e) => {
        e.preventDefault(), i.value = !0;
      },
      ondrop: (e) => {
        var r;
        e.preventDefault(), d(Array.from(((r = e.dataTransfer) == null ? void 0 : r.files) || [])), i.value = !1;
      },
      ondragleave: (e) => {
        e.preventDefault(), i.value = !1;
      }
    };
  }
  function j() {
    return {
      type: "file",
      multiple: !1,
      onChange: (e) => {
        const r = e.target;
        d(Array.from(r.files || []));
      }
    };
  }
  function z(e) {
    return typeof e == "string" ? e : URL.createObjectURL(e);
  }
  return g({
    files: u,
    dragging: i,
    errors: l,
    hasErrors: D,
    addFiles: d,
    add: f,
    remove: m,
    clear: E,
    upload: h,
    toSource: z,
    bindInput: j,
    bindDrag: S
  });
};
export {
  x as useUpload
};
