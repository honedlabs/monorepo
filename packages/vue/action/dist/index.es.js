import { ref as m, computed as f } from "vue";
import { router as v } from "@inertiajs/vue3";
function y() {
  const e = m({
    all: !1,
    only: /* @__PURE__ */ new Set(),
    except: /* @__PURE__ */ new Set()
  });
  function a() {
    e.value.all = !0, e.value.only.clear(), e.value.except.clear();
  }
  function n() {
    e.value.all = !1, e.value.only.clear(), e.value.except.clear();
  }
  function u(...l) {
    l.forEach((t) => e.value.except.delete(t)), l.forEach((t) => e.value.only.add(t));
  }
  function c(...l) {
    l.forEach((t) => e.value.except.add(t)), l.forEach((t) => e.value.only.delete(t));
  }
  function i(l, t) {
    if (r(l) || t === !1)
      return c(l);
    if (!r(l) || t === !0)
      return u(l);
  }
  function r(l) {
    return e.value.all ? !e.value.except.has(l) : e.value.only.has(l);
  }
  const o = f(() => e.value.all && e.value.except.size === 0), s = f(() => e.value.only.size > 0 || o.value);
  function d(l) {
    return {
      "onUpdate:modelValue": (t) => {
        t ? u(l) : c(l);
      },
      modelValue: r(l),
      value: l
    };
  }
  function p() {
    return {
      "onUpdate:modelValue": (l) => {
        l ? a() : n();
      },
      modelValue: o.value,
      value: o.value
    };
  }
  return {
    allSelected: o,
    selection: e,
    hasSelected: s,
    selectAll: a,
    deselectAll: n,
    select: u,
    deselect: c,
    toggle: i,
    selected: r,
    bind: d,
    bindAll: p
  };
}
function A(e, a, n = {}, u = {}) {
  return e.route ? (v.visit(e.route.url, {
    ...u,
    method: e.route.method
  }), !0) : e.action && a ? (v.post(
    a,
    {
      ...n,
      name: e.name,
      type: e.type
    },
    u
  ), !0) : !1;
}
export {
  A as executeAction,
  y as useBulk
};
