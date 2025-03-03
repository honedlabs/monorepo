import type { Message } from "./inertia"
import { resolver } from "./resolver"

export const toast = (message: Message) => {
    resolver.resolve(message)
}

export const success = (message: Message) => {
    toast({
        ...message,
        type: 'success'
    })
}

export const error = (message: Message) => {
    toast({
        ...message,
        type: 'error'
    })
}

export const info = (message: Message) => {
    toast({
        ...message,
        type: 'info'
    })
}

export const warning = (message: Message) => {
    toast({
        ...message,
        type: 'warning'
    })
}



