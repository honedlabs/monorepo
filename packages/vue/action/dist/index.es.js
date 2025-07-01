import { computed as i, ref as w } from "vue";
import { router as x } from "@inertiajs/vue3";
import b from "axios";
function v(e, c = {}, u = {}) {
  if (!e.href || !e.method)
    return !1;
  if (e.type === "inertia")
    e.method === "delete" ? x.delete(e.href, u) : x[e.method](e.href, c, u);
  else {
    const n = (a) => {
      var f;
      return (f = u.onError) == null ? void 0 : f.call(u, a);
    };
    e.method === "get" ? window.location.href = e.href : e.method === "delete" ? b.delete(e.href).catch(n) : b[e.method](e.href, c).catch(n);
  }
  return !0;
}
function o(e, c = {}, u = {}) {
  return e.map((n) => ({
    ...n,
    execute: (a = {}, f = {}) => v(n, { ...u, ...a }, { ...c, ...f })
  }));
}
function S(e, c, u = {}) {
  if (!(e != null && e[c]))
    throw new Error("The batch must be provided with valid props and key.");
  const n = i(() => e[c]), a = i(
    () => o(n.value.inline)
  ), f = i(
    () => o(n.value.bulk)
  ), h = i(
    () => o(n.value.page)
  );
  function d(r, l, t = {}) {
    return v(r, l, { ...u, ...t });
  }
  function s(r, l, t = {}) {
    return v(r, l, { ...u, ...t });
  }
  function m(r, l = {}, t = {}) {
    return v(r, l, { ...u, ...t });
  }
  return {
    inline: a,
    bulk: f,
    page: h,
    executeInline: d,
    executeBulk: s,
    executePage: m
  };
}
function V() {
  const e = w({
    all: !1,
    only: /* @__PURE__ */ new Set(),
    except: /* @__PURE__ */ new Set()
  });
  function c() {
    e.value.all = !0, e.value.only.clear(), e.value.except.clear();
  }
  function u() {
    e.value.all = !1, e.value.only.clear(), e.value.except.clear();
  }
  function n(...l) {
    l.forEach((t) => e.value.except.delete(t)), l.forEach((t) => e.value.only.add(t));
  }
  function a(...l) {
    l.forEach((t) => e.value.except.add(t)), l.forEach((t) => e.value.only.delete(t));
  }
  function f(l, t) {
    if (h(l) || t === !1) return a(l);
    if (!h(l) || t === !0) return n(l);
  }
  function h(l) {
    return e.value.all ? !e.value.except.has(l) : e.value.only.has(l);
  }
  const d = i(() => e.value.all && e.value.except.size === 0), s = i(() => e.value.only.size > 0 || d.value);
  function m(l) {
    return {
      "onUpdate:modelValue": (t) => {
        t ? n(l) : a(l);
      },
      modelValue: h(l),
      value: l
    };
  }
  function r() {
    return {
      "onUpdate:modelValue": (l) => {
        l ? c() : u();
      },
      modelValue: d.value
    };
  }
  return {
    allSelected: d,
    selection: e,
    hasSelected: s,
    selectAll: c,
    deselectAll: u,
    select: n,
    deselect: a,
    toggle: f,
    selected: h,
    bind: m,
    bindAll: r
  };
}
export {
  o as executables,
  v as execute,
  S as useBatch,
  V as useBulk
};
