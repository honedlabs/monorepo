import { parseDateTime, type CalendarDateTime } from '@internationalized/date'
import type { MaybeRefOrGetter, Ref } from 'vue'
import { reactive, ref, toValue, watch } from 'vue'

export function useQueryParameters<T extends Record<string, any> = Record<string, any>>() {
	const state: Record<string, any> = reactive({})

	function updateState() {
		const params = new URLSearchParams(window.location.search)
		const unusedKeys = new Set(Object.keys(state))
		for (const key of params.keys()) {
			const paramsForKey = params.getAll(key)
			state[key] = paramsForKey.length > 1
				? paramsForKey
				: (params.get(key) || '')
			unusedKeys.delete(key)
		}
		Array.from(unusedKeys).forEach((key) => delete state[key])
	}

	updateState()

	return state as T
}

type RouteParameter = string | number | boolean | null | undefined
type TransformFunction<V extends RouteParameter, R> = (val: V) => R
type TransformType<T extends RouteParameter, O> =
	O extends { transform: 'number' } ? number :
		O extends { transform: 'bool' } ? boolean :
			O extends { transform: 'string' } ? string :
				O extends { transform: 'date' } ? CalendarDateTime|null :
					O extends { transform: TransformFunction<T, infer R> } 
						? R 
						: T


interface UseQueryParameterOptions<V extends RouteParameter, R> {
	defaultValue?: MaybeRefOrGetter<R>
	transform?: 'number' | 'bool' | 'string' | 'date' | TransformFunction<V, R>
}

export function useQueryParameter<
  ParameterType extends RouteParameter = RouteParameter,
  Options extends UseQueryParameterOptions<ParameterType, any> = UseQueryParameterOptions<ParameterType, ParameterType>,
>(
	name: string,
	options: Options = {} as Options,
): Ref<TransformType<ParameterType, Options>> {
	const query = useQueryParameters()

	const transform = (value: ParameterType): TransformType<ParameterType, Options> => {
		switch (options.transform) {
			case 'bool':
				return (value === true || value === 'true' || value === '1' || value === 'yes') as TransformType<ParameterType, Options>
			case 'number':
				return Number(value) as TransformType<ParameterType, Options>
			case 'string':
				return String(value) as TransformType<ParameterType, Options>
			case 'date':
				try { return parseDateTime(String(value)) as TransformType<ParameterType, Options> }
				catch (error) { return null as TransformType<ParameterType, Options> }

			default:

				if (typeof options.transform === 'function') {
					return options.transform(value) as TransformType<ParameterType, Options>
				}
		}

		return value as TransformType<ParameterType, Options>
	}

	const value = ref<TransformType<ParameterType, Options>>()
	watch(query, () => {
		value.value = transform(query[name] ?? toValue(options.defaultValue) as ParameterType)
	}, { deep: true, immediate: true })

	return value as Ref<TransformType<ParameterType, Options>>
}