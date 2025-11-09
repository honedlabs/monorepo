import type { App } from "vue";
import type { FormComponent } from "./types";
import { resolveUsing } from "./resolver";

export const plugin = {
    install(app: App, options: Record<FormComponent, string>) {
        resolveUsing(options)
    }
}