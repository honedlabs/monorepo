export interface Refiner {
	name: string;
	label: string;
	type?: string;
	active: boolean;
	meta: Record<string, any>;
}
