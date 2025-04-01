import { router as m } from "@inertiajs/vue3";
import { computed as r, reactive as x, ref as h } from "vue";
function p(l, a, o = {}, n = {}) {
  return l.route ? (m.visit(l.route.url, {
    ...n,
    method: l.route.method
  }), !0) : l.action && a ? (m.post(
    a,
    {
      ...o,
      name: l.name,
      type: l.type
    },
    n
  ), !0) : !1;
}
function g(l, a, o = {}) {
  if (!l || !a || !l[a])
    throw new Error(
      "The action group must be provided with valid props and key."
    );
  const n = r(() => l[a]), v = r(
    () => n.value.inline.map((t) => ({
      ...t,
      execute: (e, u = {}) => c(t, e, u)
    }))
  ), s = r(
    () => n.value.bulk.map((t) => ({
      ...t,
      execute: (e, u = {}) => f(t, e, u)
    }))
  ), i = r(
    () => n.value.page.map((t) => ({
      ...t,
      execute: (e = {}, u = {}) => d(t, e, u)
    }))
  );
  function c(t, e, u = {}) {
    p(
      t,
      n.value.endpoint,
      {
        ...e,
        id: n.value.id,
        name: t.name,
        type: t.type
      },
      {
        ...o,
        ...u
      }
    );
  }
  function f(t, e, u = {}) {
    p(
      t,
      n.value.endpoint,
      {
        ...e,
        id: n.value.id
      },
      {
        ...o,
        ...u
      }
    );
  }
  function d(t, e = {}, u = {}) {
    p(
      t,
      n.value.endpoint,
      {
        ...e,
        id: n.value.id
      },
      {
        ...o,
        ...u
      }
    );
  }
  return x({
    inline: v,
    bulk: s,
    page: i,
    executeInlineAction: c,
    executeBulkAction: f,
    executePageAction: d
  });
}
function b() {
  const l = h({
    all: !1,
    only: /* @__PURE__ */ new Set(),
    except: /* @__PURE__ */ new Set()
  });
  function a() {
    l.value.all = !0, l.value.only.clear(), l.value.except.clear();
  }
  function o() {
    l.value.all = !1, l.value.only.clear(), l.value.except.clear();
  }
  function n(...e) {
    e.forEach((u) => l.value.except.delete(u)), e.forEach((u) => l.value.only.add(u));
  }
  function v(...e) {
    e.forEach((u) => l.value.except.add(u)), e.forEach((u) => l.value.only.delete(u));
  }
  function s(e, u) {
    if (i(e) || u === !1)
      return v(e);
    if (!i(e) || u === !0)
      return n(e);
  }
  function i(e) {
    return l.value.all ? !l.value.except.has(e) : l.value.only.has(e);
  }
  const c = r(() => l.value.all && l.value.except.size === 0), f = r(() => l.value.only.size > 0 || c.value);
  function d(e) {
    return {
      "onUpdate:modelValue": (u) => {
        u ? n(e) : v(e);
      },
      modelValue: i(e),
      value: e
    };
  }
  function t() {
    return {
      "onUpdate:modelValue": (e) => {
        e ? a() : o();
      },
      modelValue: c.value,
      value: c.value
    };
  }
  return {
    allSelected: c,
    selection: l,
    hasSelected: f,
    selectAll: a,
    deselectAll: o,
    select: n,
    deselect: v,
    toggle: s,
    selected: i,
    bind: d,
    bindAll: t
  };
}
export {
  p as executeAction,
  g as useActions,
  b as useBulk
};
