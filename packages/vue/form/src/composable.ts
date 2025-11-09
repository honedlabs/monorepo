import { resolve } from "./resolver"
import { Render } from "./component"
import type { Form } from "./types"
import { getComponent, getComponents } from "./utils"

export function useComponents(form: Form) {
    return {
        resolve,
        getComponent,
        getComponents,
        Render: (errors?: Record<string, string>) => Render({ form, errors }),
    }
}