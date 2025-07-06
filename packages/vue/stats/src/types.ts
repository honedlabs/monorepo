import { ComputedRef } from "vue";

export interface StatValue {
	name: string;
	label: string;
	icon?: string;
	description?: string;
	attributes?: Record<string, any>;
}

export interface StatProps {
	_values: StatValue[];
	_stat_key: string;
}

export interface Stat extends StatValue {
	stat: () => any;
}

export interface Overview {
	values: ComputedRef<Stat[]>;
	statKey: ComputedRef<string>;
	getStat: (key: string) => any;
}
