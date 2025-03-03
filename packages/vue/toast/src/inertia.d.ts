import "@inertiajs/vue3"
import { Page } from "@inertiajs/core"

export interface Message {
    message: string
    type?: 'success' | 'error' | 'info' | 'warning' | string
    title?: string | null
    duration?: number | null
    meta?: Record<string, any>
}

declare module "@inertiajs/vue3" {
    export declare function usePage(): Page<{ toast: Message | null }>
}

export {}