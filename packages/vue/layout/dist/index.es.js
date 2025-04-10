import { createInertiaApp as c } from "@inertiajs/vue3";
async function f(o) {
  const { id: a = "app", resolve: n, layout: r, ...s } = o, t = typeof window > "u" ? null : document.getElementById(a), u = JSON.parse((t == null ? void 0 : t.dataset.layout) || "{}");
  return c({ ...s, id: a, resolve: async (l) => {
    const e = await n(l), i = await r(u);
    return e.default.layout = e.default.layout || i, e.default;
  } });
}
export {
  f as createInertiaApp
};
