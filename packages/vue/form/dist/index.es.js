import { ref as m, defineAsyncComponent as d, h as v } from "vue";
import { router as g } from "@inertiajs/vue3";
const r = /* @__PURE__ */ new Map(), i = m({});
function C(n) {
  return d({
    loader: () => import(i.value[n])
  });
}
function s(n) {
  if (!r.has(n)) {
    const o = C(n);
    return r.set(n, o), o;
  }
  return r.get(n);
}
function h(n) {
  i.value = {
    ...i.value,
    ...n
  };
}
function u(n, o = {}) {
  const { component: t, attributes: a = {}, ...p } = n, { schema: l, ...e } = p, f = "name" in e ? { error: o[e.name] } : {};
  return v(
    s(t),
    {
      ...a,
      ...e,
      ...f
    },
    [...c(l, o)]
  );
}
function c(n, o) {
  return n === void 0 ? [] : n.map((t) => u(t, o));
}
function R(n) {
  const { form: o, errors: t } = n;
  return c(o.schema, t);
}
function x(n) {
  function o(t) {
    n.cancel === "reset" ? t == null || t() : n.cancel !== void 0 && g.visit(n.cancel);
  }
  return {
    resolve: s,
    getComponent: u,
    getComponents: c,
    onCancel: o,
    Render: (t) => R({ form: n, errors: t })
  };
}
const y = {
  install(n, o) {
    h(o);
  }
};
export {
  R as Render,
  u as getComponent,
  c as getComponents,
  C as load,
  y as plugin,
  s as resolve,
  h as resolveUsing,
  x as useComponents
};
