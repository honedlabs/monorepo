import { computed as a } from "vue";
function c(e) {
  const s = a(
    () => e._values.map((t) => ({
      ...t,
      stat: () => n(t.name)
    }))
  ), u = a(() => e._stat_key);
  function n(t) {
    return e[t];
  }
  return {
    values: s,
    statKey: u,
    getStat: n
  };
}
export {
  c as useStats
};
