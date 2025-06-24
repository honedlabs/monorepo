import { computed as f, reactive as b, ref as g } from "vue";
import { router as x } from "@inertiajs/vue3";
function y(e, c, o = {}, u = {}) {
  return e.route ? (x.visit(e.route.url, {
    ...u,
    method: e.route.method
  }), !0) : e.action && c ? (x.post(
    c,
    {
      ...o,
      name: e.name,
      type: e.type
    },
    u
  ), !0) : !1;
}
function S(e, c, o = {}) {
  if (!(e != null && e[c]))
    throw new Error(
      "The operation group must be provided with valid props and key."
    );
  const u = f(() => e[c]);
  function r(l, n = {}, a = {}) {
    y(
      l,
      u.value.endpoint,
      {
        ...n,
        id: u.value.id
      },
      {
        ...o,
        ...a
      }
    );
  }
  function v(l) {
    return l.map((n) => ({
      ...n,
      execute: (a = {}, p = {}) => r(n, a, p)
    }));
  }
  const i = f(
    () => v(u.value.inline)
  ), s = f(() => v(u.value.bulk)), d = f(() => v(u.value.page));
  function h(l, n, a = {}) {
    r(l, n, a);
  }
  function m(l, n, a = {}) {
    r(l, n, a);
  }
  function t(l, n = {}, a = {}) {
    r(l, n, a);
  }
  return b({
    inline: i,
    bulk: s,
    page: d,
    executeInline: h,
    executeBulk: m,
    executePage: t
  });
}
function V() {
  const e = g({
    all: !1,
    only: /* @__PURE__ */ new Set(),
    except: /* @__PURE__ */ new Set()
  });
  function c() {
    e.value.all = !0, e.value.only.clear(), e.value.except.clear();
  }
  function o() {
    e.value.all = !1, e.value.only.clear(), e.value.except.clear();
  }
  function u(...t) {
    t.forEach((l) => e.value.except.delete(l)), t.forEach((l) => e.value.only.add(l));
  }
  function r(...t) {
    t.forEach((l) => e.value.except.add(l)), t.forEach((l) => e.value.only.delete(l));
  }
  function v(t, l) {
    if (i(t) || l === !1)
      return r(t);
    if (!i(t) || l === !0)
      return u(t);
  }
  function i(t) {
    return e.value.all ? !e.value.except.has(t) : e.value.only.has(t);
  }
  const s = f(() => e.value.all && e.value.except.size === 0), d = f(() => e.value.only.size > 0 || s.value);
  function h(t) {
    return {
      "onUpdate:modelValue": (l) => {
        l ? u(t) : r(t);
      },
      modelValue: i(t),
      value: t
    };
  }
  function m() {
    return {
      "onUpdate:modelValue": (t) => {
        t ? c() : o();
      },
      modelValue: s.value
    };
  }
  return {
    allSelected: s,
    selection: e,
    hasSelected: d,
    selectAll: c,
    deselectAll: o,
    select: u,
    deselect: r,
    toggle: v,
    selected: i,
    bind: h,
    bindAll: m
  };
}
export {
  y as executeOperation,
  S as useBatch,
  V as useBulk
};
