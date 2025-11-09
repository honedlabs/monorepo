import type { Method } from "@inertiajs/core"

export interface RenderProps {
    form: Form
    errors?: Record<string, any>
}

export type FormComponent = 'checkbox' | 'color' | 'date' | 'fieldgroup' | 'fieldset' | 'input' | 'legend' | 'lookup' | 'number' | 'radio' | 'select' | 'text' | 'textarea' | string

export interface Form {
    method: Method
    action?: string
    cancel?: 'reset' | string
    schema: Component[]
}

export interface Option {
    label: string
    value: number | string | boolean | null
}

export interface Component {
    component: FormComponent
    attributes?: Record<string, any>
}

export interface Field<T extends any = any> extends Component {
    name: string
    label: string
    hint?: string
    value?: T
    required?: boolean
    disabled?: boolean
    optional?: boolean
    autofocus?: boolean
}

export interface Grouping extends Component {
    schema?: Component[]
}

export interface Checkbox extends Field<boolean> {
    component: 'checkbox'
}

export interface Color extends Field<string> {
    component: 'color'
}

export interface Date extends Field {
    component: 'date'
}

export interface FieldGroup extends Grouping {
    component: 'fieldgroup'
}

export interface Fieldset extends Grouping {
    component: 'fieldset'
}

export interface Input extends Field {
    component: 'input'
}

export interface Legend extends Component {
    component: 'legend'
    label?: string
}

export interface Lookup extends Selection {
    component: 'lookup'
    url: string
    method: Method
    pending?: string
}

export interface NumberInput extends Field<number> {
    component: 'number'
}

export interface Radio extends Field {
    component: 'radio'
    options?: Option[]
}

export interface Select extends Selection {
    component: 'select'
}

export interface Selection extends Field {
    placeholder?: string
    multiple?: boolean
    options?: Option[]
}

export interface Text extends Component {
    component: 'text'
    text?: string
}

export interface Textarea extends Textfield {
    component: 'textarea'
}

export interface Textfield extends Field {
    placeholder?: string
}