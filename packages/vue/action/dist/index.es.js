import { computed as d, ref as w } from "vue";
import { router as m } from "@inertiajs/vue3";
import y from "axios";
function E(e, n, r, u = {}) {
  if (e.route) {
    const { url: i, method: c } = e.route;
    return e.inertia ? window.location.href = i : m.visit(i, { ...u, method: c }), !0;
  }
  if (!e.action || !n)
    return !1;
  const a = {
    ...r,
    name: e.name,
    type: e.type
  };
  return e.inertia ? m.post(n, a, u) : y.post(n, a).catch((i) => {
    var c;
    return (c = u.onError) == null ? void 0 : c.call(u, i);
  }), !0;
}
function b(e, n, r, u = {}, a = {}) {
  return E(
    e,
    n,
    { ...u, id: r ?? void 0 },
    a
  );
}
function g(e, n, r, u = {}) {
  return e.map((a) => ({
    ...a,
    execute: (i = {}, c = {}) => b(a, n, r, i, { ...u, ...c })
  }));
}
function B(e, n, r = {}) {
  if (!(e != null && e[n]))
    throw new Error("The batch must be provided with valid props and key.");
  const u = d(() => e[n]), a = d(
    () => s(u.value.inline)
  ), i = d(
    () => s(u.value.bulk)
  ), c = d(
    () => s(u.value.page)
  );
  function f(t, o = {}, v = {}) {
    return b(
      t,
      u.value.endpoint,
      u.value.id,
      o,
      { ...r, ...v }
    );
  }
  function s(t) {
    return g(
      t,
      u.value.endpoint,
      u.value.id,
      r
    );
  }
  function x(t, o, v = {}) {
    return f(t, o, v);
  }
  function h(t, o, v = {}) {
    return f(t, o, v);
  }
  function l(t, o = {}, v = {}) {
    return f(t, o, v);
  }
  return {
    inline: a,
    bulk: i,
    page: c,
    executeInline: x,
    executeBulk: h,
    executePage: l
  };
}
function p() {
  const e = w({
    all: !1,
    only: /* @__PURE__ */ new Set(),
    except: /* @__PURE__ */ new Set()
  });
  function n() {
    e.value.all = !0, e.value.only.clear(), e.value.except.clear();
  }
  function r() {
    e.value.all = !1, e.value.only.clear(), e.value.except.clear();
  }
  function u(...l) {
    l.forEach((t) => e.value.except.delete(t)), l.forEach((t) => e.value.only.add(t));
  }
  function a(...l) {
    l.forEach((t) => e.value.except.add(t)), l.forEach((t) => e.value.only.delete(t));
  }
  function i(l, t) {
    if (c(l) || t === !1) return a(l);
    if (!c(l) || t === !0) return u(l);
  }
  function c(l) {
    return e.value.all ? !e.value.except.has(l) : e.value.only.has(l);
  }
  const f = d(() => e.value.all && e.value.except.size === 0), s = d(() => e.value.only.size > 0 || f.value);
  function x(l) {
    return {
      "onUpdate:modelValue": (t) => {
        t ? u(l) : a(l);
      },
      modelValue: c(l),
      value: l
    };
  }
  function h() {
    return {
      "onUpdate:modelValue": (l) => {
        l ? n() : r();
      },
      modelValue: f.value
    };
  }
  return {
    allSelected: f,
    selection: e,
    hasSelected: s,
    selectAll: n,
    deselectAll: r,
    select: u,
    deselect: a,
    toggle: i,
    selected: c,
    bind: x,
    bindAll: h
  };
}
export {
  g as executables,
  E as execute,
  b as executor,
  B as useBatch,
  p as useBulk
};
