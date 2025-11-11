import { ref as v, defineAsyncComponent as g, h as i, defineComponent as p } from "vue";
import { router as C } from "@inertiajs/vue3";
const o = /* @__PURE__ */ new Map(), u = v({});
function h(e) {
  return g({
    loader: () => import(u.value[e])
  });
}
function a(e) {
  if (!o.has(e)) {
    const n = h(e);
    return o.set(e, n), n;
  }
  return o.get(e);
}
function b(e) {
  u.value = {
    ...u.value,
    ...e
  };
}
function s(e, n = {}) {
  const { component: t, attributes: f = {}, ...d } = e, { schema: l, ...r } = d, m = "name" in r ? { error: n[r.name] } : {};
  return i(
    a(t),
    {
      ...f,
      ...r,
      ...m
    },
    {
      default: c(l, n)
    }
  );
}
function c(e, n) {
  return e === void 0 ? () => [] : () => e.map((t) => s(t, n));
}
const y = p({
  setup(e, { slots: n }) {
    return () => {
      var t;
      return (t = n.default) == null ? void 0 : t.call(n);
    };
  }
}), j = p({
  props: {
    form: {
      type: Object,
      required: !0
    },
    errors: {
      type: Object,
      required: !0
    }
  },
  setup(e) {
    return () => i(
      y,
      {},
      {
        default: c(e.form.schema, e.errors)
      }
    );
  }
});
function R(e) {
  function n(t) {
    e.cancel === "reset" ? t == null || t() : e.cancel !== void 0 && C.visit(e.cancel);
  }
  return {
    resolve: a,
    getComponent: s,
    getComponents: c,
    onCancel: n,
    Render: (t = {}) => i(j, { form: e, errors: t })
  };
}
const w = {
  install(e, n) {
    b(n);
  }
};
export {
  j as Render,
  s as getComponent,
  c as getComponents,
  h as load,
  w as plugin,
  a as resolve,
  b as resolveUsing,
  R as useComponents
};
