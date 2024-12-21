import { describe, it, expect, vi, beforeEach } from 'vitest'
import { can, canAny } from '../src'

vi.mock('@inertiajs/vue3', () => ({
    usePage: vi.fn(() => ({
        props: {

        }
    }))
}))

beforeEach(() => {
    vi.clearAllMocks()
})

it('tests', () => {
    expect(true).toBe(true)
})

