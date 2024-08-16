import type { StringSchema } from 'yup'

export const stringRules: any = {
  required: (validator: StringSchema) => validator.required(),
  email: (validator: StringSchema) => validator.email(),
  min: (validator: StringSchema, value: number) => validator.min(value),
  max: (validator: StringSchema, value: number) => validator.max(value)
};