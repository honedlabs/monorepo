import type { Message } from "./inertia"
import { resolver } from "./resolver"

type MessageParam = Message | string

const normalise = (message: MessageParam): Message => 
    typeof message === 'string' ? { message } : message

const message = (type?: Message['type']) => (message: MessageParam) => {
    const baseMessage = normalise(message)
    resolver.resolve(type ? { ...baseMessage, type } : baseMessage)
}

export const flash = message()
export const success = message('success')
export const error = message('error')
export const info = message('info')
export const warning = message('warning')

export const useFlash = () => ({
    message: flash,
    success,
    error,
    info,
    warning
})