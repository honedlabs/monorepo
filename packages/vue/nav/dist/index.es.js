import { usePage as t } from "@inertiajs/vue3";
import { computed as r } from "vue";
const n = t();
function u(e) {
  const o = r(() => n.props.nav);
  return e ? r(() => o.value[e] ?? []) : o;
}
export {
  u as useNav
};
