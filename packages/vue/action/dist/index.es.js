import { computed as d, ref as w } from "vue";
import { router as m } from "@inertiajs/vue3";
import y from "axios";
function E(e, n, r, u = {}) {
  if (e.route) {
    const { url: i, method: a } = e.route;
    return e.inertia ? window.location.href = i : m.visit(i, { ...u, method: a }), !0;
  }
  if (!e.action || !n)
    return !1;
  const c = {
    ...r,
    name: e.name,
    type: e.type
  };
  return e.inertia ? m.post(n, c, u) : y.post(n, c).catch((i) => {
    var a;
    return (a = u.onError) == null ? void 0 : a.call(u, i);
  }), !0;
}
function b(e, n, r, u = {}, c = {}) {
  return E(
    e,
    n,
    { ...u, id: r ?? void 0 },
    c
  );
}
function g(e, n, r, u = {}, c = {}) {
  return e.map((i) => ({
    ...i,
    execute: (a = {}, f = {}) => b(
      i,
      n,
      r,
      { ...c, ...a },
      { ...u, ...f }
    )
  }));
}
function B(e, n, r = {}) {
  if (!(e != null && e[n]))
    throw new Error("The batch must be provided with valid props and key.");
  const u = d(() => e[n]), c = d(
    () => s(u.value.inline)
  ), i = d(
    () => s(u.value.bulk)
  ), a = d(
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
    inline: c,
    bulk: i,
    page: a,
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
  function c(...l) {
    l.forEach((t) => e.value.except.add(t)), l.forEach((t) => e.value.only.delete(t));
  }
  function i(l, t) {
    if (a(l) || t === !1) return c(l);
    if (!a(l) || t === !0) return u(l);
  }
  function a(l) {
    return e.value.all ? !e.value.except.has(l) : e.value.only.has(l);
  }
  const f = d(() => e.value.all && e.value.except.size === 0), s = d(() => e.value.only.size > 0 || f.value);
  function x(l) {
    return {
      "onUpdate:modelValue": (t) => {
        t ? u(l) : c(l);
      },
      modelValue: a(l),
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
    deselect: c,
    toggle: i,
    selected: a,
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
