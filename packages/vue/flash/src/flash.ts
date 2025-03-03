import type { Message } from "./inertia"
import { resolver } from "./resolver"

export const useFlash = (message: Message) => {
    resolver.resolve(message)
}

export const success = (message: Message) => {
    useFlash({
        ...message,
        type: 'success'
    })
}

export const error = (message: Message) => {
    useFlash({
        ...message,
        type: 'error'
    })
}

export const info = (message: Message) => {
    useFlash({
        ...message,
        type: 'info'
    })
}

export const warning = (message: Message) => {
    useFlash({
        ...message,
        type: 'warning'
    })
}



