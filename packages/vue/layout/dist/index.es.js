import { createInertiaApp as p } from "@inertiajs/vue3";
async function f(o) {
  const { id: a = "app", resolve: n, layout: r, ...s } = o, e = typeof window > "u" ? null : document.getElementById(a), l = JSON.parse((e == null ? void 0 : e.dataset.page) || "{}");
  return p({ ...s, id: a, resolve: async (u) => {
    const t = await n(u), i = await r(l.layout);
    return t.default.layout = t.default.layout || i.default, t.default;
  } });
}
export {
  f as createInertiaApp
};
