// stores/counter.js
import {defineStore} from 'pinia'
import {ValidationError} from 'yup'
import {createYupSchema} from '../validation/schema'

type Value<T> = {
    [value: string]: T;
}

interface Values<T> {
    [form: string]: Value<T>;
}

interface Loading {
    [form: string]: boolean;
}

interface Errors extends Values<string> {
}

interface Validation extends Values<{}> {
}

type FormState = {
    values: Values<string>,
    validation: Validation,
    errors: Errors,
    loading: Loading,
}

export const useFormStore = defineStore('form', {
    /**
     * State
     */
    state: (): FormState => {
        return {
            values: {},
            validation: {},
            errors: {},
            loading: {},
        }
    },
    /**
     * Actions
     */
    actions: {
        /**
         * Set form loading state
         * @param form
         * @param value
         */
        setLoading(form: string, value: boolean) {
            this.$patch({
                loading: {
                    [form]: value,
                }
            })
        },

        /**
         * Set form errors
         * @param form
         * @param value
         */
        setErrors(form: string, value: any) {
            this.$patch({
                errors: {
                    [form]: value,
                }
            })
        },

        /**
         * Set field error
         * @param form
         * @param field
         * @param value
         */
        setFieldError(form: string, field: string, value: any) {
            this.$patch({
                errors: {
                    [form]: {
                        [field]: value
                    },
                }
            })
        },

        /**
         * Clear field error
         * @param form
         * @param field
         */
        clearFieldError(form: string, field: string): void {
            this.setFieldError(form, field, '');
        },

        /**
         * Get field error
         * @param form
         * @param field
         */
        getFieldError(form: string, field: string): string {
            return this.errors[form][field];
        },

        /**
         *
         * @param form
         */
        getValues(form: string): Value<string> {
            return this.values[form];
        },


        /**
         * Is field loading
         * @param form
         */
        isLoading(form: string): boolean {
            return this.loading[form];
        },

        /**
         * Clear all form errors
         * @param form
         */
        clearAllErrors(form: string) {
            Object.entries(this.errors[form]).forEach(({0: field}) => {
                this.clearFieldError(form, field);
            })
        },

        /**
         * Submit given form
         * @param form
         */
        async submit(form: string, action: string): Promise<any> {
            const yupSchema = createYupSchema(this.validation[form]);
            this.clearAllErrors(form);

            try {
                const res = await yupSchema.validate(this.getValues(form), {abortEarly: false});
            } catch (e: any) {
                e.inner.reverse().forEach((e: ValidationError) => {
                    this.setFieldError(form, e.path ?? '', e.message);
                });
                throw e;
            }

            try {
                const values = this.getValues(form);
                this.setLoading(form, true);

                const res = await $fetch(action, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': `Bearer lalalal`,
                    },
                    body: JSON.stringify(values)
                });
                this.setLoading(form, false);

                return res;
            } catch (e: any) {
                Object.values(e.data.errors).forEach((e: any) => {
                    this.setFieldError(form, e.key ?? '', e.message);
                });
                this.setLoading(form, false);
            }
        }
    }
})