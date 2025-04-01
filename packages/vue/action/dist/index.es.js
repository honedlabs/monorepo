import { router as m } from "@inertiajs/vue3";
import { computed as r, reactive as x, ref as h } from "vue";
function p(l, a, o = {}, t = {}) {
  return l.route ? (m.visit(l.route.url, {
    ...t,
    method: l.route.method
  }), !0) : l.action && a ? (m.post(
    a,
    {
      ...o,
      name: l.name,
      type: l.type
    },
    t
  ), !0) : !1;
}
function b(l, a, o = {}) {
  if (!l || !a || !l[a])
    throw new Error(
      "The action group must be provided with valid props and key."
    );
  const t = r(() => l[a]), v = r(
    () => t.value.inline.map((n) => ({
      ...n,
      execute: (e, u = {}) => c(n, e, u)
    }))
  ), s = r(
    () => t.value.bulk.map((n) => ({
      ...n,
      execute: (e, u = {}) => f(n, e, u)
    }))
  ), i = r(
    () => t.value.page.map((n) => ({
      ...n,
      execute: (e = {}, u = {}) => d(n, e, u)
    }))
  );
  function c(n, e, u = {}) {
    p(
      n,
      t.value.endpoint,
      {
        ...e,
        id: t.value.id
      },
      {
        ...o,
        ...u
      }
    );
  }
  function f(n, e, u = {}) {
    p(
      n,
      t.value.endpoint,
      {
        ...e,
        id: t.value.id
      },
      {
        ...o,
        ...u
      }
    );
  }
  function d(n, e = {}, u = {}) {
    p(
      n,
      t.value.endpoint,
      {
        ...e,
        id: t.value.id
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
function w() {
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
  function t(...e) {
    e.forEach((u) => l.value.except.delete(u)), e.forEach((u) => l.value.only.add(u));
  }
  function v(...e) {
    e.forEach((u) => l.value.except.add(u)), e.forEach((u) => l.value.only.delete(u));
  }
  function s(e, u) {
    if (i(e) || u === !1)
      return v(e);
    if (!i(e) || u === !0)
      return t(e);
  }
  function i(e) {
    return l.value.all ? !l.value.except.has(e) : l.value.only.has(e);
  }
  const c = r(() => l.value.all && l.value.except.size === 0), f = r(() => l.value.only.size > 0 || c.value);
  function d(e) {
    return {
      "onUpdate:modelValue": (u) => {
        u ? t(e) : v(e);
      },
      modelValue: i(e),
      value: e
    };
  }
  function n() {
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
    select: t,
    deselect: v,
    toggle: s,
    selected: i,
    bind: d,
    bindAll: n
  };
}
export {
  p as executeAction,
  b as useActions,
  w as useBulk
};
