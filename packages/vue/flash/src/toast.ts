import type { Message } from "./inertia"
import { resolver } from "./resolver"

export const flash = (message: Message) => {
    resolver.resolve(message)
}

export const success = (message: Message) => {
    flash({
        ...message,
        type: 'success'
    })
}

export const error = (message: Message) => {
    flash({
        ...message,
        type: 'error'
    })
}

export const info = (message: Message) => {
    flash({
        ...message,
        type: 'info'
    })
}

export const warning = (message: Message) => {
    flash({
        ...message,
        type: 'warning'
    })
}