import { App } from 'vue';
import { ComponentOptionsMixin } from 'vue';
import { ComponentProvideOptions } from 'vue';
import { ComputedRef } from 'vue';
import { DefineComponent } from 'vue';
import { PublicProps } from 'vue';
import { Ref } from 'vue';
import { VisitOptions } from '@inertiajs/core';

export declare const Modal: DefineComponent<    {}, () => any, {}, {}, {}, ComponentOptionsMixin, ComponentOptionsMixin, {}, string, PublicProps, Readonly<{}> & Readonly<{}>, {}, {}, {}, {}, string, ComponentProvideOptions, true, {}, any>;

export declare const modal: {
    install(app: App, options: ModalPluginOptions): void;
};

export declare type ModalPluginOptions = {
    resolve: (name: string) => any;
};

export declare const useModal: () => {
    show: Ref<boolean, boolean>;
    vnode: Ref<any, any>;
    close: () => void;
    redirect: (options?: VisitOptions) => void;
    props: ComputedRef<Record<string, any>>;
};

export { }
