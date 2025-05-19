import { DefineComponent } from "vue";
import { createInertiaApp as inertiaApp } from "@inertiajs/vue3";

const FORMATTER = "@";

type CreateInertiaAppParameters = Parameters<typeof inertiaApp>[0];

export interface CreateInertiaAppProps extends CreateInertiaAppParameters {
	resolveLayout: (
		name: string | null,
	) =>
		| DefineComponent
		| Promise<DefineComponent>
		| { default: DefineComponent };
}

export async function createInertiaApp(props: CreateInertiaAppProps) {
	const { id = "app", resolve, resolveLayout, ...rest } = props;

	const layoutResolve = async (name: string) => {
		const [pageName, layoutName] = name.split(FORMATTER);

		const page = await Promise.resolve(resolve(pageName)).then(
			(p) => p.default || p,
		);

		if (layoutName) {
			const layout = await Promise.resolve(resolveLayout(layoutName)).then(
				(l) => l.default || l,
			);

			page.layout = page.layout || layout;
		}

		return page;
	};

	return inertiaApp({ ...rest, id, resolve: layoutResolve });
}
