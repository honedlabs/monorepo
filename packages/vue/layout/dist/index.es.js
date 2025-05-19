import { createInertiaApp as u } from "@inertiajs/vue3";
const y = "@";
async function f(r) {
  const { id: s = "app", resolve: n, resolveLayout: l, ...c } = r;
  return u({ ...c, id: s, resolve: async (i) => {
    const [p, a] = i.split(y), t = await Promise.resolve(n(p)).then(
      (e) => e.default || e
    );
    if (a) {
      const e = await Promise.resolve(l(a)).then(
        (o) => o.default || o
      );
      t.layout = t.layout || e;
    }
    return t;
  } });
}
export {
  f as createInertiaApp
};
