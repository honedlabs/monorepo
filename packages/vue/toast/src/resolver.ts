import { ref } from "vue"
import type { Message } from './inertia'

export type ResolveCallback = (message: Message) => void

const resolveCallback = ref<ResolveCallback>()

export const resolver = {
    setResolveCallback: (callback: ResolveCallback) => {
        resolveCallback.value = callback
    },
    resolve: (message: Message) => resolveCallback.value!(message),
}