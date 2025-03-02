import { App } from "vue";
export type ModalPluginOptions = {
    resolve: (name: string) => any;
};
export declare const plugin: {
    install(app: App, options: ModalPluginOptions): void;
};
