import * as yup from 'yup'
import { useStringRules } from './rules'
const stringRules = useStringRules();
export const useCreateYupSchema = (schema: any) => {
  const yupSchema: any = {};
  for (const key in schema) {
    const field = schema[key];

    if (!field) {
      continue;
    }

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