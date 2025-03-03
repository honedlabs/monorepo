import { App } from "vue"
import { resolver, type ResolveCallback } from "./resolver"
import { router, usePage } from "@inertiajs/vue3"

export type ToastPluginOptions = {
    resolve: ResolveCallback
}

export const plugin = {
    install(app: App, options: ToastPluginOptions) {
        resolver.setResolveCallback(options.resolve)

        router.on('finish', () => {
            const toast = usePage().props.toast

            if (toast) {
                resolver.resolve(toast)
            }
        })
    }
}