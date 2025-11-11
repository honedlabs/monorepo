import type { Method } from "@inertiajs/core";
import type { HTMLAttributes, VNode } from "vue";
import { FormComponent } from "./enum";

export interface Form {
	method: Method;
	action?: string;
	cancel?: "reset" | string;
	schema: Component[];
}

export interface Resolver {
	(name: string): VNode | Promise<VNode>;
}

export type ResolveKey = {
	[key: string]: string | VNode;
} & {
	[K in FormComponent]?: string | VNode;
};

export interface Option {
	label: string;
	value: number | string | boolean | null;
}

export interface Component {
	component: string;
	attributes?: Record<string, any>;
}

export interface Checkbox extends Field<boolean> {
	component: "checkbox";
}

export interface Color extends Field<string> {
	component: "color";
}

export interface Date extends Field {
	component: "date";
}

export interface Field<T extends any = any> extends Component {
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
	class?: HTMLAttributes["class"];
}

export interface FieldGroup extends Grouping {
	component: "fieldgroup";
}

export interface Fieldset extends Grouping {
	component: "fieldset";
}

export interface Grouping extends Component {
	schema?: Component[];
	class?: HTMLAttributes["class"];
}

export interface Input extends Field {
	component: "input";
	placeholder?: string;
	type?: string;
}

export interface Legend extends Component {
	component: "legend";
	label?: string;
}

export interface Search extends Selection {
	component: "search";
	url: string;
	method: Method;
	pending?: string;
}

export interface NumberInput extends Field<number> {
	component: "number";
}

export interface Radio extends Field {
	component: "radio";
	options?: Option[];
}

export interface Select extends Selection {
	component: "select";
}

export interface Selection extends Field {
	placeholder?: string;
	multiple?: boolean;
	options?: Option[];
}

export interface Text extends Component {
	component: "text";
	text?: string;
}

export interface Textarea extends Textfield {
	component: "textarea";
}

export interface Textfield extends Field {
	placeholder?: string;
}
