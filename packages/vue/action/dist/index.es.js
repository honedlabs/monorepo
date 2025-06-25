import { computed as v, reactive as p, ref as y } from "vue";
import { router as m } from "@inertiajs/vue3";
function g(e, n, a, l = {}) {
  return e.route ? (m.visit(e.route.url, {
    ...l,
    method: e.route.method
  }), !0) : e.action && n ? (m.post(
    n,
    {
      ...a,
      name: e.name,
      type: e.type
    },
    l
  ), !0) : !1;
}
function b(e, n, a, l = {}, c = {}) {
  return g(
    e,
    n,
    {
      ...l,
      id: a ?? void 0
    },
    {
      ...c
    }
  );
}
function w(e, n, a, l = {}) {
  return e.map((c) => ({
    ...c,
    execute: (d = {}, r = {}) => b(c, n, a, d, { ...l, ...r })
  }));
}
function V(e, n, a = {}) {
  if (!(e != null && e[n]))
    throw new Error("The batch must be provided with valid props and key.");
  const l = v(() => e[n]), c = v(() => s(l.value.inline)), d = v(() => s(l.value.bulk)), r = v(() => s(l.value.page));
  function i(u, o = {}, f = {}) {
    return b(
      u,
      l.value.endpoint,
      l.value.id,
      o,
      {
        ...a,
        ...f
      }
    );
  }
  function s(u) {
    return w(
      u,
      l.value.endpoint,
      l.value.id,
      a
    );
  }
  function x(u, o, f = {}) {
    return i(u, o, f);
  }
  function h(u, o, f = {}) {
    return i(u, o, f);
  }
  function t(u, o = {}, f = {}) {
    return i(u, o, f);
  }
  return p({
    inline: c,
    bulk: d,
    page: r,
    executeInline: x,
    executeBulk: h,
    executePage: t
  });
}
function A() {
  const e = y({
    all: !1,
    only: /* @__PURE__ */ new Set(),
    except: /* @__PURE__ */ new Set()
  });
  function n() {
    e.value.all = !0, e.value.only.clear(), e.value.except.clear();
  }
  function a() {
    e.value.all = !1, e.value.only.clear(), e.value.except.clear();
  }
  function l(...t) {
    t.forEach((u) => e.value.except.delete(u)), t.forEach((u) => e.value.only.add(u));
  }
  function c(...t) {
    t.forEach((u) => e.value.except.add(u)), t.forEach((u) => e.value.only.delete(u));
  }
  function d(t, u) {
    if (r(t) || u === !1) return c(t);
    if (!r(t) || u === !0) return l(t);
  }
  function r(t) {
    return e.value.all ? !e.value.except.has(t) : e.value.only.has(t);
  }
  const i = v(() => e.value.all && e.value.except.size === 0), s = v(() => e.value.only.size > 0 || i.value);
  function x(t) {
    return {
      "onUpdate:modelValue": (u) => {
        u ? l(t) : c(t);
      },
      modelValue: r(t),
      value: t
    };
  }
  function h() {
    return {
      "onUpdate:modelValue": (t) => {
        t ? n() : a();
      },
      modelValue: i.value
    };
  }
  return {
    allSelected: i,
    selection: e,
    hasSelected: s,
    selectAll: n,
    deselectAll: a,
    select: l,
    deselect: c,
    toggle: d,
    selected: r,
    bind: x,
    bindAll: h
  };
}
export {
  w as executables,
  g as execute,
  b as executor,
  V as useBatch,
  A as useBulk
};
