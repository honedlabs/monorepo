import { ComputedRef } from 'vue';

export declare interface Overview {
    values: ComputedRef<Stat[]>;
    statKey: ComputedRef<string>;
    getStat: (key: string) => any;
}

export declare interface Stat extends StatValue {
    stat: () => any;
}

export declare interface StatProps {
    _values: StatValue[];
    _stat_key: string;
}

export declare interface StatValue {
    name: string;
    label: string;
    icon?: string;
    description?: string;
    attributes?: Record<string, any>;
}

export declare function useStats<T extends StatProps>(props: T): Overview;

export { }
