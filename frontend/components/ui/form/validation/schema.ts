import * as yup from 'yup'
import { stringRules } from './rules'

export const createYupSchema = (schema: any) => {
  const yupSchema: any = {};
  for (const key in schema) {
    const field = schema[key];
    let validator: yup.StringSchema = yup.string();

    for (const rule in field) {
      const ruleValue = field[rule];
      if (stringRules[rule] && ruleValue !== false) {
        validator = stringRules[rule](validator, ruleValue);
      }
    }

    yupSchema[key] = validator;
  }

  return yup.object().shape(yupSchema);
}