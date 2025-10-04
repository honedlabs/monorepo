export interface InfolistValue {
    v?: any
    e?: Record<string, any>
    c?: string
    f?: boolean
    a?: string
}

export function useInfolist() {
    function value(entry: InfolistValue) {
        return entry.v ?? null
    }
    function extra(entry: InfolistValue) {
        return entry.e ?? null
    }
    function attributes(entry: InfolistValue) {
        return entry.c ?? {}
    }
    function variant(entry: InfolistValue) {
        return entry.a ?? null
    }

    return {
        value,
        extra,
        attributes,
        variant,
    }
}