import { App } from 'vue';
import { DefineComponent } from 'vue';
import { Page } from '@inertiajs/core';
import { Plugin as Plugin_2 } from 'vue';

declare function createInertiaApp({ id, resolve, layout: layoutResolver, setup, title, progress, page, render, }: CreateInertiaAppProps): Promise<{
    head: string[];
    body: string;
} | void>;
export default createInertiaApp;

export declare interface CreateInertiaAppProps {
    id?: string;
    resolve: (name: string) => DefineComponent | Promise<DefineComponent> | {
        default: DefineComponent;
    };
    layout: (layout: string) => DefineComponent | Promise<DefineComponent> | {
        default: DefineComponent;
    };
    setup: (props: {
        el: Element;
        App: InertiaApp;
        props: InertiaAppProps;
        plugin: Plugin_2;
    }) => void | App;
    title?: (title: string) => string;
    progress?: false | {
        delay?: number;
        color?: string;
        includeCSS?: boolean;
        showSpinner?: boolean;
    };
    page?: Page;
    render?: (app: App) => Promise<string>;
}

declare type InertiaApp = DefineComponent<InertiaAppProps>;

declare interface InertiaAppProps {
    initialPage: Page;
    initialComponent?: object;
    resolveComponent?: (name: string) => DefineComponent | Promise<DefineComponent>;
    titleCallback?: (title: string) => string;
    onHeadUpdate?: (elements: string[]) => void;
}

export { }


declare module "@inertiajs/vue3" {
    interface PageProps {
        layout: string | null;
    }
}
