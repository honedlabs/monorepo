import { computed as f, reactive as p, ref as y } from "vue";
import { router as m } from "@inertiajs/vue3";
function g(e, n, c = {}, u = {}) {
  return e.route ? (m.visit(e.route.url, {
    ...u,
    method: e.route.method
  }), !0) : e.action && n ? (m.post(
    n,
    {
      ...c,
      name: e.name,
      type: e.type
    },
    u
  ), !0) : !1;
}
function b(e, n, c, u = {}, a = {}) {
  g(
    e,
    n,
    {
      ...u,
      id: c ?? void 0
    },
    {
      ...a
    }
  );
}
function w(e, n, c, u = {}) {
  return e.map((a) => ({
    ...a,
    execute: (v = {}, i = {}) => b(a, n, c, v, { ...u, ...i })
  }));
}
function V(e, n, c = {}) {
  if (!(e != null && e[n]))
    throw new Error("The batch must be provided with valid props and key.");
  const u = f(() => e[n]);
  function a(t, o = {}, r = {}) {
    b(t, u.value.endpoint, u.value.id, o, {
      ...c,
      ...r
    });
  }
  const v = f(() => s(u.value.inline)), i = f(() => s(u.value.bulk)), d = f(() => s(u.value.page));
  function s(t) {
    return w(
      t,
      u.value.endpoint,
      u.value.id,
      c
    );
  }
  function x(t, o, r = {}) {
    a(t, o, r);
  }
  function h(t, o, r = {}) {
    a(t, o, r);
  }
  function l(t, o = {}, r = {}) {
    a(t, o, r);
  }
  return p({
    inline: v,
    bulk: i,
    page: d,
    executeInline: x,
    executeBulk: h,
    executePage: l
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
  function c() {
    e.value.all = !1, e.value.only.clear(), e.value.except.clear();
  }
  function u(...l) {
    l.forEach((t) => e.value.except.delete(t)), l.forEach((t) => e.value.only.add(t));
  }
  function a(...l) {
    l.forEach((t) => e.value.except.add(t)), l.forEach((t) => e.value.only.delete(t));
  }
  function v(l, t) {
    if (i(l) || t === !1) return a(l);
    if (!i(l) || t === !0) return u(l);
  }
  function i(l) {
    return e.value.all ? !e.value.except.has(l) : e.value.only.has(l);
  }
  const d = f(() => e.value.all && e.value.except.size === 0), s = f(() => e.value.only.size > 0 || d.value);
  function x(l) {
    return {
      "onUpdate:modelValue": (t) => {
        t ? u(l) : a(l);
      },
      modelValue: i(l),
      value: l
    };
  }
  function h() {
    return {
      "onUpdate:modelValue": (l) => {
        l ? n() : c();
      },
      modelValue: d.value
    };
  }
  return {
    allSelected: d,
    selection: e,
    hasSelected: s,
    selectAll: n,
    deselectAll: c,
    select: u,
    deselect: a,
    toggle: v,
    selected: i,
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
