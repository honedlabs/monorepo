import { ref as m, computed as f } from "vue";
import { router as s } from "@inertiajs/vue3";
function y() {
  const e = m({
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
  function u(...l) {
    l.forEach((t) => e.value.except.delete(t)), l.forEach((t) => e.value.only.add(t));
  }
  function r(...l) {
    l.forEach((t) => e.value.except.add(t)), l.forEach((t) => e.value.only.delete(t));
  }
  function i(l, t) {
    if (o(l) || t === !1)
      return r(l);
    if (!o(l) || t === !0)
      return u(l);
  }
  function o(l) {
    return e.value.all ? !e.value.except.has(l) : e.value.only.has(l);
  }
  const c = f(() => e.value.all && e.value.except.size === 0), v = f(() => e.value.only.size > 0 || c.value);
  function d(l) {
    return {
      "onUpdate:modelValue": (t) => {
        console.log("Checked:", t), t ? u(l) : r(l);
      },
      modelValue: o(l),
      value: l
    };
  }
  function p() {
    return {
      "onUpdate:modelValue": (l) => {
        console.log("Checked:", l), l ? n() : a();
      },
      modelValue: c.value
    };
  }
  return {
    allSelected: c,
    selection: e,
    hasSelected: v,
    selectAll: n,
    deselectAll: a,
    select: u,
    deselect: r,
    toggle: i,
    selected: o,
    bind: d,
    bindAll: p
  };
}
function g(e, n, a = {}, u = {}) {
  return e.route ? (s.visit(e.route.href, {
    ...u,
    method: e.route.method
  }), !0) : e.action && n ? (s.post(
    n,
    {
      ...a,
      name: e.name,
      type: e.type
    },
    u
  ), !0) : !1;
}
export {
  g as executeAction,
  y as useBulk
};
