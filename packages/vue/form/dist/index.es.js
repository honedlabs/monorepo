import { ref as f, defineAsyncComponent as R, h as s, defineComponent as l } from "vue";
import { router as h } from "@inertiajs/vue3";
const i = /* @__PURE__ */ new Map(), u = f({}), c = f();
function p(e) {
  return c.value || (c.value = O), c.value(e);
}
function O(e) {
  if (i.has(e))
    return i.get(e);
  const r = u.value[e];
  if (!r)
    throw new Error(`A mapping has not been provided for [${e}]`);
  const t = R({ loader: r });
  return i.set(e, t), t;
}
function T(e, r = {}) {
  typeof e == "function" ? (c.value = e, u.value = {
    ...u.value,
    ...r
  }) : u.value = {
    ...u.value,
    ...e
  };
}
function d(e, r = {}) {
  const { component: t, attributes: n = {}, ...v } = e, { schema: E, ...a } = v, g = a.name ? r[a.name] : void 0;
  return s(
    p(t),
    {
      ...n,
      ...a,
      error: g
    },
    {
      default: o(E, r)
    }
  );
}
function o(e, r) {
  return e === void 0 ? () => [] : () => e.map((t) => d(t, r));
}
const b = l({
  setup(e, { slots: r }) {
    return () => {
      var t;
      return (t = r.default) == null ? void 0 : t.call(r);
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
      b,
      {},
      {
        default: o(e.form.schema, e.errors)
      }
    );
  }
});
function x(e) {
  function r(n) {
    e.cancel === "reset" ? n == null || n() : e.cancel !== void 0 ? h.visit(e.cancel) : n == null || n();
  }
  const t = l({
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
    getComponents: o,
    onCancel: r,
    Render: t
  };
}
const I = {
  install(e, r) {
    const t = r.components || {};
    T(r.resolver || t, t);
  }
};
var y = /* @__PURE__ */ ((e) => (e.CHECKBOX = "checkbox", e.COLOR = "color", e.DATE = "date", e.FIELDGROUP = "fieldgroup", e.FIELDSET = "fieldset", e.INPUT = "input", e.LEGEND = "legend", e.NUMBER = "number", e.RADIO = "radio", e.SEARCH = "search", e.SELECT = "select", e.TEXT = "text", e.TEXTAREA = "textarea", e))(y || {});
export {
  y as FormComponent,
  A as Render,
  O as defaultResolver,
  d as getComponent,
  o as getComponents,
  I as plugin,
  p as resolve,
  T as resolveUsing,
  x as useComponents
};
