import { AllowedComponentProps } from 'vue';
import { App } from 'vue';
import { ComponentCustomProps } from 'vue';
import { ComponentOptionsMixin } from 'vue';
import { ComputedRef } from 'vue';
import { DefineComponent } from 'vue';
import { ExtractPropTypes } from 'vue';
import { Ref } from 'vue';
import { VisitOptions } from '@inertiajs/core';
import { VNodeProps } from 'vue';

export declare const Modal: DefineComponent<    {}, () => any, {}, {}, {}, ComponentOptionsMixin, ComponentOptionsMixin, {}, string, VNodeProps & AllowedComponentProps & ComponentCustomProps, Readonly<ExtractPropTypes<    {}>>, {}>;

export declare const modal: {
    install(app: App, options: ModalPluginOptions): void;
};

export declare type ModalPluginOptions = {
    resolve: (name: string) => any;
};

export declare const useModal: () => {
    show: Ref<boolean>;
    vnode: Ref<any>;
    close: () => void;
    redirect: (options?: VisitOptions) => void;
    props: ComputedRef<Record<string, any>>;
};

export { }
