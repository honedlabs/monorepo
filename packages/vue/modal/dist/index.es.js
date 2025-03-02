import { ref as n, computed as v, shallowRef as M, watch as h, defineAsyncComponent as C, h as L, nextTick as b, defineComponent as E } from "vue";
import { usePage as I, router as U } from "@inertiajs/vue3";
import d from "axios";
const m = n(), R = {
  setResolveCallback: (e) => {
    m.value = e;
  },
  resolve: (e) => m.value(e)
}, N = {
  install(e, t) {
    R.setResolveCallback(t.resolve);
  }
}, c = I(), a = v(() => {
  var e;
  return (e = c == null ? void 0 : c.props) == null ? void 0 : e.modal;
}), k = v(() => {
  var e;
  return (e = a.value) == null ? void 0 : e.props;
}), i = v(() => {
  var e;
  return (e = a.value) == null ? void 0 : e.key;
}), r = n(), s = M(), p = n(!1), f = n(), u = n(), X = (e) => {
  Object.entries(e).forEach(
    ([t, l]) => ["post", "put", "patch", "delete"].forEach((o) => {
      d.defaults.headers[o][t] = l;
    })
  );
}, g = () => {
  ["X-Inertia-Modal-Key", "X-Inertia-Modal-Redirect"].forEach(
    ([t, l]) => ["get", "post", "put", "patch", "delete"].forEach((o) => {
      delete d.defaults.headers[o][t];
    })
  );
}, x = () => {
  var e, t;
  X({
    "X-Inertia-Modal-Key": i.value,
    "X-Inertia-Modal-Redirect": (e = a.value) == null ? void 0 : e.redirectURL
  }), d.defaults.headers.get["X-Inertia-Modal-Redirect"] = ((t = a.value) == null ? void 0 : t.redirectURL) ?? "";
}, w = () => {
  p.value = !1, g();
}, y = () => {
  var e, t, l, o;
  if (u.value == ((e = a.value) == null ? void 0 : e.nonce) || !((t = a.value) != null && t.component))
    return w();
  r.value != ((l = a.value) == null ? void 0 : l.component) && (r.value = a.value.component, r.value ? s.value = C(() => R.resolve(r.value)) : s.value = !1), u.value = (o = a.value) == null ? void 0 : o.nonce, f.value = s.value ? L(s.value, {
    key: i.value,
    ...k.value
  }) : "", b(() => p.value = !0);
};
y();
typeof window < "u" && window.addEventListener("popstate", (e) => {
  u.value = null;
});
h(
  a,
  () => {
    var e;
    ((e = a.value) == null ? void 0 : e.nonce) !== u.value && y();
  },
  { deep: !0 }
);
h(i, x);
const H = (e = {}) => {
  var l, o;
  var t = ((l = a.value) == null ? void 0 : l.redirectURL) ?? ((o = a.value) == null ? void 0 : o.baseURL);
  if (f.value = !1, !!t)
    return U.visit(t, {
      preserveScroll: !0,
      preserveState: !0,
      ...e
    });
}, K = () => ({
  show: p,
  vnode: f,
  close: w,
  redirect: H,
  props: k
}), O = E({
  setup() {
    const { vnode: e } = K();
    return () => e.value;
  }
});
export {
  O as Modal,
  N as modal,
  K as useModal
};
