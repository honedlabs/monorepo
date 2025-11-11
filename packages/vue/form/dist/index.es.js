import { ref as g, defineAsyncComponent as v, computed as R, h as i, defineComponent as a } from "vue";
import { router as O } from "@inertiajs/vue3";
const u = /* @__PURE__ */ new Map(), c = g({});
function T(e) {
  return v({
    loader: () => import(c.value[e])
  });
}
function l(e) {
  if (!u.has(e)) {
    const r = T(e);
    return u.set(e, r), r;
  }
  return u.get(e);
}
function b(e) {
  c.value = {
    ...c.value,
    ...e
  };
}
function p(e, r = {}) {
  const { component: n, attributes: t = {}, ...d } = e, { schema: o, ...f } = d, E = R(() => r[f.name]);
  return i(
    l(n),
    {
      ...t,
      ...f,
      error: E
    },
    {
      default: s(o, r)
    }
  );
}
function s(e, r) {
  return e === void 0 ? () => [] : () => e.map((n) => p(n, r));
}
const h = a({
  setup(e, { slots: r }) {
    return () => {
      var n;
      return (n = r.default) == null ? void 0 : n.call(r);
    };
  }
}), A = a({
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
      h,
      {},
      {
        default: s(e.form.schema, e.errors)
      }
    );
  }
});
function y(e) {
  function r(t) {
    e.cancel === "reset" ? t == null || t() : e.cancel !== void 0 ? O.visit(e.cancel) : t == null || t();
  }
  const n = a({
    props: {
      errors: {
        type: Object,
        default: () => ({})
      }
    },
    setup(t) {
      return () => i(A, { form: e, errors: t.errors });
    }
  });
  return {
    resolve: l,
    getComponent: p,
    getComponents: s,
    onCancel: r,
    Render: n
  };
}
const I = {
  install(e, r) {
    b(r);
  }
};
var D = /* @__PURE__ */ ((e) => (e.CHECKBOX = "checkbox", e.COLOR = "color", e.DATE = "date", e.FIELDGROUP = "fieldgroup", e.FIELDSET = "fieldset", e.INPUT = "input", e.LEGEND = "legend", e.NUMBER = "number", e.RADIO = "radio", e.SEARCH = "search", e.SELECT = "select", e.TEXT = "text", e.TEXTAREA = "textarea", e))(D || {});
export {
  D as FormComponent,
  A as Render,
  p as getComponent,
  s as getComponents,
  T as load,
  I as plugin,
  l as resolve,
  b as resolveUsing,
  y as useComponents
};
