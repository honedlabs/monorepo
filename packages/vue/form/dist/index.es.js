import { ref as p, defineAsyncComponent as g, computed as O, h as a, defineComponent as s } from "vue";
import { router as T } from "@inertiajs/vue3";
const c = /* @__PURE__ */ new Map(), i = p({}), n = p();
function d(e) {
  return n.value || (n.value = b), n.value(e);
}
function b(e) {
  if (!c.has(e)) {
    const t = g({
      loader: () => import(i.value[e])
    });
    return c.set(e, t), t;
  }
  return c.get(e);
}
function h(e) {
  typeof e == "function" ? n.value = e : i.value = {
    ...i.value,
    ...e
  };
}
function o(e, t = {}) {
  const { component: u, attributes: r = {}, ...v } = e, { schema: E, ...f } = v, R = O(() => t[f.name]);
  return a(
    d(u),
    {
      ...r,
      ...f,
      error: R
    },
    {
      default: l(E, t)
    }
  );
}
function l(e, t) {
  return e === void 0 ? () => [] : () => e.map((u) => o(u, t));
}
const A = s({
  setup(e, { slots: t }) {
    return () => {
      var u;
      return (u = t.default) == null ? void 0 : u.call(t);
    };
  }
}), y = s({
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
    return () => a(
      A,
      {},
      {
        default: l(e.form.schema, e.errors)
      }
    );
  }
});
function I(e) {
  function t(r) {
    e.cancel === "reset" ? r == null || r() : e.cancel !== void 0 ? T.visit(e.cancel) : r == null || r();
  }
  const u = s({
    props: {
      errors: {
        type: Object,
        default: () => ({})
      }
    },
    setup(r) {
      return () => a(y, { form: e, errors: r.errors });
    }
  });
  return {
    resolve: d,
    getComponent: o,
    getComponents: l,
    onCancel: t,
    Render: u
  };
}
const U = {
  install(e, t) {
    h(t);
  }
};
var D = /* @__PURE__ */ ((e) => (e.CHECKBOX = "checkbox", e.COLOR = "color", e.DATE = "date", e.FIELDGROUP = "fieldgroup", e.FIELDSET = "fieldset", e.INPUT = "input", e.LEGEND = "legend", e.NUMBER = "number", e.RADIO = "radio", e.SEARCH = "search", e.SELECT = "select", e.TEXT = "text", e.TEXTAREA = "textarea", e))(D || {});
export {
  D as FormComponent,
  y as Render,
  b as defaultResolver,
  o as getComponent,
  l as getComponents,
  U as plugin,
  d as resolve,
  h as resolveUsing,
  I as useComponents
};
