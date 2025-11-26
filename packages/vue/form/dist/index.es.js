import { ref as o, defineAsyncComponent as g, h as s, defineComponent as l } from "vue";
import { router as O } from "@inertiajs/vue3";
const i = /* @__PURE__ */ new Map(), u = o({}), c = o();
function p(e) {
  return c.value || (c.value = T), c.value(e);
}
function T(e) {
  if (!i.has(e)) {
    const t = g({
      loader: () => import(u.value[e])
    });
    return i.set(e, t), t;
  }
  return i.get(e);
}
function b(e, t = {}) {
  typeof e == "function" ? (c.value = e, u.value = {
    ...u.value,
    ...t
  }) : u.value = {
    ...u.value,
    ...e
  };
}
function d(e, t = {}) {
  const { component: r, attributes: n = {}, ...v } = e, { schema: E, ...a } = v, R = a.name ? t[a.name] : void 0;
  return s(
    p(r),
    {
      ...n,
      ...a,
      error: R
    },
    {
      default: f(E, t)
    }
  );
}
function f(e, t) {
  return e === void 0 ? () => [] : () => e.map((r) => d(r, t));
}
const h = l({
  setup(e, { slots: t }) {
    return () => {
      var r;
      return (r = t.default) == null ? void 0 : r.call(t);
    };
  }
}), A = l({
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
    return () => s(
      h,
      {},
      {
        default: f(e.form.schema, e.errors)
      }
    );
  }
});
function x(e) {
  function t(n) {
    e.cancel === "reset" ? n == null || n() : e.cancel !== void 0 ? O.visit(e.cancel) : n == null || n();
  }
  const r = l({
    props: {
      errors: {
        type: Object,
        default: () => ({})
      }
    },
    setup(n) {
      return () => s(A, { form: e, errors: n.errors });
    }
  });
  return {
    resolve: p,
    getComponent: d,
    getComponents: f,
    onCancel: t,
    Render: r
  };
}
const I = {
  install(e, t) {
    const r = t.components || {};
    b(t.resolver || r, r);
  }
};
var y = /* @__PURE__ */ ((e) => (e.CHECKBOX = "checkbox", e.COLOR = "color", e.DATE = "date", e.FIELDGROUP = "fieldgroup", e.FIELDSET = "fieldset", e.INPUT = "input", e.LEGEND = "legend", e.NUMBER = "number", e.RADIO = "radio", e.SEARCH = "search", e.SELECT = "select", e.TEXT = "text", e.TEXTAREA = "textarea", e))(y || {});
export {
  y as FormComponent,
  A as Render,
  T as defaultResolver,
  d as getComponent,
  f as getComponents,
  I as plugin,
  p as resolve,
  b as resolveUsing,
  x as useComponents
};
