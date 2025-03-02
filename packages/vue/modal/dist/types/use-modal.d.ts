import { VisitOptions } from "@inertiajs/core";
export declare const useModal: () => {
    show: import("vue").Ref<boolean>;
    vnode: import("vue").Ref<any>;
    close: () => void;
    redirect: (options?: VisitOptions) => void;
    props: import("vue").ComputedRef<Record<string, any>>;
};
