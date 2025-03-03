import { App } from "vue"
import { resolver, type ResolveCallback } from "./resolver"
import { router, usePage } from "@inertiajs/vue3"

export type FlashPluginOptions = {
    resolve: ResolveCallback
}

export const plugin = {
    install(app: App, options: FlashPluginOptions) {
        resolver.setResolveCallback(options.resolve)

        router.on('finish', () => {
            const flash = usePage().props.flash

            if (flash) {
                resolver.resolve(flash)
            }
        })
    }
}