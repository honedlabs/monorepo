import { DefineComponent } from "vue";
import { createInertiaApp as inertiaApp } from "@inertiajs/vue3";

type CreateInertiaAppParameters = Parameters<typeof inertiaApp>[0];

export interface CreateInertiaAppProps extends CreateInertiaAppParameters {
	layout: (
		name: string | null,
	) =>
		| DefineComponent
		| Promise<DefineComponent>
		| { default: DefineComponent };
}

export async function createInertiaApp(props: CreateInertiaAppProps) {
	const { id = "app", resolve, layout, ...rest } = props;

	const isServer = typeof window === "undefined";
	const el = isServer ? null : document.getElementById(id);
	const initialPage = JSON.parse(el?.dataset.page || "{}");

	const layoutResolve = async (name: string) => {
		const page = await resolve(name);

		const pageLayout = await layout(initialPage.layout);

		page.default.layout = page.default.layout || pageLayout.default;

		return page.default;
	};

	return inertiaApp({ ...rest, id, resolve: layoutResolve });
}
