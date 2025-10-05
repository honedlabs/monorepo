declare type Replaces = Record<string, string | number>;

export declare function useLang(): {
    __: (key: string, replaces?: Replaces | string) => string;
    trans: (key: string, replaces?: Replaces | string) => string;
};

export { }
