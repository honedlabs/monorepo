import { VNode } from "vue";
import { Form, RenderProps } from "./types";
import { getComponents } from "./utils";

export function Render(props: RenderProps): VNode[] {
    const { form, errors } = props

    return getComponents(form.schema, errors)
}