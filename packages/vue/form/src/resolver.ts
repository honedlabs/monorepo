import { defineAsyncComponent, ref } from "vue";
import type { FormComponent } from "./types";

const mappings = ref<Record<FormComponent, string>>({})

export function resolve(name: FormComponent) {
    return defineAsyncComponent(() => import(mappings.value[name]))
}

export function resolveUsing(newMappings: Record<FormComponent, string>) {
    mappings.value = {
        ...mappings.value,
        ...newMappings
    }
}