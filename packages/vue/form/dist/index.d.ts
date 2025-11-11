import { App } from 'vue';
import { ComponentOptionsMixin } from 'vue';
import { ComponentProvideOptions } from 'vue';
import { DefineComponent } from 'vue';
import { ExtractPropTypes } from 'vue';
import { Method } from '@inertiajs/core';
import { PropType } from 'vue';
import { PublicProps } from 'vue';
import { RendererElement } from 'vue';
import { RendererNode } from 'vue';
import { VNode } from 'vue';

export declare interface Checkbox extends Field<boolean> {
    component: "checkbox";
}

export declare interface Color extends Field<string> {
    component: "color";
}

export declare interface Component {
    component: FormComponent;
    attributes?: Record<string, any>;
}

declare interface Date_2 extends Field {
    component: "date";
}
export { Date_2 as Date }

export declare interface Field<T extends any = any> extends Component {
    name: string;
    label: string;
    hint?: string;
    value?: T;
    required?: boolean;
    disabled?: boolean;
    optional?: boolean;
    autofocus?: boolean;
    min?: number;
    max?: number;
    error?: string;
}

export declare interface FieldGroup extends Grouping {
    component: "fieldgroup";
}

export declare interface Fieldset extends Grouping {
    component: "fieldset";
}

export declare interface Form {
    method: Method;
    action?: string;
    cancel?: "reset" | string;
    schema: Component[];
}

export declare type FormComponent = "checkbox" | "color" | "date" | "fieldgroup" | "fieldset" | "input" | "legend" | "lookup" | "number" | "radio" | "select" | "text" | "textarea" | string;

export declare function getComponent(formComponent: Component, errors?: Record<string, string>): VNode;

export declare function getComponents(schema?: Component[], errors?: Record<string, string>): () => VNode[];

export declare interface Grouping extends Component {
    schema?: Component[];
}

export declare interface Input extends Field {
    component: "input";
    placeholder?: string;
    type?: string;
}

export declare interface Legend extends Component {
    component: "legend";
    label?: string;
}

export declare function load(name: FormComponent): Promise<VNode>;

export declare interface Lookup extends Selection_2 {
    component: "lookup";
    url: string;
    method: Method;
    pending?: string;
}

export declare interface NumberInput extends Field<number> {
    component: "number";
}

declare interface Option_2 {
    label: string;
    value: number | string | boolean | null;
}
export { Option_2 as Option }

export declare const plugin: {
    install(app: App, options: Record<FormComponent, string>): void;
};

export declare interface Radio extends Field {
    component: "radio";
    options?: Option_2[];
}

export declare const Render: DefineComponent<ExtractPropTypes<    {
form: {
type: PropType<Form>;
required: true;
};
errors: {
type: PropType<Record<string, string>>;
required: true;
};
}>, () => VNode<RendererNode, RendererElement, {
[key: string]: any;
}>, {}, {}, {}, ComponentOptionsMixin, ComponentOptionsMixin, {}, string, PublicProps, Readonly<ExtractPropTypes<    {
form: {
type: PropType<Form>;
required: true;
};
errors: {
type: PropType<Record<string, string>>;
required: true;
};
}>> & Readonly<{}>, {}, {}, {}, {}, string, ComponentProvideOptions, true, {}, any>;

export declare function resolve(name: FormComponent): Promise<VNode>;

export declare function resolveUsing(newMappings: Record<FormComponent, string>): void;

export declare interface Select extends Selection_2 {
    component: "select";
}

declare interface Selection_2 extends Field {
    placeholder?: string;
    multiple?: boolean;
    options?: Option_2[];
}
export { Selection_2 as Selection }

declare interface Text_2 extends Component {
    component: "text";
    text?: string;
}
export { Text_2 as Text }

export declare interface Textarea extends Textfield {
    component: "textarea";
}

export declare interface Textfield extends Field {
    placeholder?: string;
}

export declare function useComponents(form: Form): {
    resolve: typeof resolve;
    getComponent: typeof getComponent;
    getComponents: typeof getComponents;
    onCancel: (reset?: () => void) => void;
    Render: (errors?: Record<string, string>) => VNode;
};

export { }
