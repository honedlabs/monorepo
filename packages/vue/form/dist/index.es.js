import { ref as v, defineAsyncComponent as g, computed as C, h as c, defineComponent as p } from "vue";
import { router as b } from "@inertiajs/vue3";
const o = /* @__PURE__ */ new Map(), u = v({});
function h(e) {
  return g({
    loader: () => import(u.value[e])
  });
}
function s(e) {
  if (!o.has(e)) {
    const n = h(e);
    return o.set(e, n), n;
  }
  return o.get(e);
}
function y(e) {
  u.value = {
    ...u.value,
    ...e
  };
}
function f(e, n = {}) {
  const { component: t, attributes: r = {}, ...d } = e, { schema: l, ...a } = d, m = C(() => n[a.name]);
  return c(
    s(t),
    {
      ...r,
      ...a,
      error: m
    },
    {
      default: i(l, n)
    }
  );
}
function i(e, n) {
  return e === void 0 ? () => [] : () => e.map((t) => f(t, n));
}
const j = p({
  setup(e, { slots: n }) {
    return () => {
      var t;
      return (t = n.default) == null ? void 0 : t.call(n);
    };
  }
}), O = p({
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
    return () => c(
      j,
      {},
      {
        default: i(e.form.schema, e.errors)
      }
    );
  }
});
function w(e) {
  function n(r) {
    e.cancel === "reset" ? r == null || r() : e.cancel !== void 0 && b.visit(e.cancel), r == null || r();
  }
  const t = p({
    props: {
      errors: {
        type: Object,
        default: () => ({})
      }
    },
    setup(r) {
      return () => c(O, { form: e, errors: r.errors });
    }
  });
  return {
    resolve: s,
    getComponent: f,
    getComponents: i,
    onCancel: n,
    Render: t
  };
}
const x = {
  install(e, n) {
    y(n);
  }
};
export {
  O as Render,
  f as getComponent,
  i as getComponents,
  h as load,
  x as plugin,
  s as resolve,
  y as resolveUsing,
  w as useComponents
};
