import { usePage as r } from "@inertiajs/vue3";
import { computed as t } from "vue";
const a = r(), s = (e) => {
  const o = t(() => a.props.nav);
  return e ? o.value[e] ?? [] : o.value;
};
export {
  s as useNav
};
