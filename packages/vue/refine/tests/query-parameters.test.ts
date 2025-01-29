import { describe, it, expect, beforeEach, vi } from 'vitest'
import { useQueryParameter, useQueryParameters } from '../src/query-parameters'
import { nextTick } from 'vue'
import { parseDateTime } from '@internationalized/date'

describe('Query Parameters', () => {
  // Create a proper window.location mock
  let locationMock: { search: string }

  beforeEach(() => {
    // Reset and setup location mock
    locationMock = { search: '' }
    Object.defineProperty(window, 'location', {
      value: locationMock,
      writable: true
    })
  })

  // Helper to set URL search params
  const setUrlParams = (params: Record<string, string>) => {
    const searchParams = new URLSearchParams(params)
    locationMock.search = `?${searchParams.toString()}`
  }

  // Helper to set multiple URL params
  const setMultipleUrlParams = (key: string, values: string[]) => {
    const searchParams = new URLSearchParams()
    values.forEach(value => searchParams.append(key, value))
    locationMock.search = `?${searchParams.toString()}`
  }

  describe('useQueryParameters', () => {
    it('returns an empty reactive object when no parameters exist', () => {
      const params = useQueryParameters()
      expect(params).toEqual({})
    })

    it('returns all URL parameters as a reactive object', () => {
      setUrlParams({ name: 'john', age: '25' })
      const params = useQueryParameters()
      expect(params).toEqual({ name: 'john', age: '25' })
    })

    it('handles multiple values for the same parameter', () => {
      setMultipleUrlParams('tags', ['vue', 'typescript'])
      const params = useQueryParameters()
      expect(params.tags).toEqual(['vue', 'typescript'])
    })
  })

  describe('useQueryParameter', () => {
    it('returns a single parameter value', async () => {
      setUrlParams({ name: 'john' })
      const name = useQueryParameter('name')
      expect(name.value).toBe('john')
    })

    it('handles default values', () => {
      const age = useQueryParameter('age', { defaultValue: '25' })
      expect(age.value).toBe('25')
    })

    describe('transformations', () => {
      it('transforms to number', () => {
        setUrlParams({ age: '25' })
        const age = useQueryParameter('age', { transform: 'number' })
        expect(age.value).toBe(25)
      })

      it('transforms to boolean - truthy values', () => {
        const truthyValues = ['true', '1', 'yes']
        truthyValues.forEach(value => {
          setUrlParams({ active: value })
          const active = useQueryParameter('active', { transform: 'bool' })
          expect(active.value).toBe(true)
        })
      })

      it('transforms to boolean - falsy values', () => {
        setUrlParams({ active: 'false' })
        const active = useQueryParameter('active', { transform: 'bool' })
        expect(active.value).toBe(false)
      })

      it('transforms to string', () => {
        setUrlParams({ count: '42' })
        const count = useQueryParameter('count', { transform: 'string' })
        expect(count.value).toBe('42')
      })

      it('transforms to date', () => {
        const dateString = '2024-03-15'
        setUrlParams({ date: dateString })
        const date = useQueryParameter('date', { transform: 'date' })
        expect(date.value).toEqual(parseDateTime(dateString))
      })

      it('returns null for invalid date', () => {
        setUrlParams({ date: 'invalid-date' })
        const date = useQueryParameter('date', { transform: 'date' })
        expect(date.value).toBeNull()
      })

      it('handles custom transform function', () => {
        setUrlParams({ tags: 'vue,typescript,testing' })
        const tags = useQueryParameter('tags', {
          transform: (value: string) => value.split(',')
        })
        expect(tags.value).toEqual(['vue', 'typescript', 'testing'])
      })
    })

    it('reactively updates when URL changes', async () => {
      setUrlParams({ count: '1' })
      const count = useQueryParameter('count', { transform: 'number' })
      expect(count.value).toBe(1)
    })

    it('handles missing parameters', () => {
      const missing = useQueryParameter('nonexistent')
      expect(missing.value).toBeUndefined()
    })

    it('handles missing parameters with default value', () => {
      const param = useQueryParameter('nonexistent', { defaultValue: 'default' })
      expect(param.value).toBe('default')
    })
  })
})
