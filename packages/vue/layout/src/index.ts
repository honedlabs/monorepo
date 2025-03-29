import { Page, router, setupProgress } from '@inertiajs/core'
import { DefineComponent, Plugin, App as VueApp, createSSRApp, h } from 'vue'

export interface InertiaAppProps {
    initialPage: Page
    initialComponent?: object
    resolveComponent?: (name: string) => DefineComponent | Promise<DefineComponent>
    titleCallback?: (title: string) => string
    onHeadUpdate?: (elements: string[]) => void
}

export type InertiaApp = DefineComponent<InertiaAppProps>

export interface CreateInertiaAppProps {
    id?: string
    resolve: (name: string) => DefineComponent | Promise<DefineComponent> | { default: DefineComponent }
    layout: (layout: string) => DefineComponent | Promise<DefineComponent> | { default: DefineComponent }
    setup: (props: { el: Element; App: InertiaApp; props: InertiaAppProps; plugin: Plugin }) => void | VueApp
    title?: (title: string) => string
    progress?:
    | false
    | {
        delay?: number
        color?: string
        includeCSS?: boolean
        showSpinner?: boolean
    }
    page?: Page
    render?: (app: VueApp) => Promise<string>
}

export default async function createInertiaApp({
    id = 'app',
    resolve,
    layout: layoutResolver,
    setup,
    title,
    progress = {},
    page,
    render,
}: CreateInertiaAppProps): Promise<{ head: string[]; body: string }|void> {
    const isServer = typeof window === 'undefined'
    const el = isServer ? null : document.getElementById(id)    
    const initialPage = page || JSON.parse(el!.dataset.page as string)
    const initialLayout = JSON.parse(el!.dataset.layout as string)

    const resolveComponent = async (page: string, layout: string|null) => {
        const pageComponent = await resolve(page)
        const layoutComponent = layout ? await layoutResolver(layout) : null
        pageComponent.default.layout = pageComponent.default.layout || layoutComponent
        return pageComponent
    }

    
    let head: string[] = []
    
    const vueApp = await Promise.all([
        resolveComponent(initialPage.component, initialLayout.component),
        router.decryptHistory().catch(() => {}),
    ]).then(([initialComponent]) => {
        return setup({
            el: el as Element,
            App,
            props: {
                initialPage,
                initialComponent,
                resolveComponent,
                titleCallback: title,
                onHeadUpdate: isServer ? (elements: string[]) => (head = elements) : null,
            },
            plugin,
        })
    })
    
    if (!isServer && progress) {
        setupProgress(progress)
    }
    
    if (isServer && render) {
        const body = await render(
            createSSRApp({
                render: () =>
                    h('div', {
                        id,
                        'data-page': JSON.stringify(initialPage),
                        innerHTML: vueApp ? render(vueApp) : '',
                    }
                ),
            }),
        )
        
        return { head, body }
    }
}