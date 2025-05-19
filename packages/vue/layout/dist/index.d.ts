import { createInertiaApp as createInertiaApp_2 } from '@inertiajs/vue3';
import { DefineComponent } from 'vue';

export declare function createInertiaApp(props: CreateInertiaAppProps): Promise<{
    head: string[];
    body: string;
}>;

declare type CreateInertiaAppParameters = Parameters<typeof createInertiaApp_2>[0];

export declare interface CreateInertiaAppProps extends CreateInertiaAppParameters {
    resolveLayout: (name: string | null) => DefineComponent | Promise<DefineComponent> | {
        default: DefineComponent;
    };
}

export { }
