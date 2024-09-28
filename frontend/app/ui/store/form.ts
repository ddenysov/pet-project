// stores/counter.js
import {defineStore} from 'pinia'
import {bool, ValidationError} from 'yup'
import {useCreateYupSchema} from '../composables/validation/schema'
import {useApi} from "~/app/shared/api/composables/api";
import type {FormState, Value} from "~/app/ui/types/form";

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
         * Has field error
         * @param form
         * @param field
         */
        hasFieldError(form: string, field: string): boolean {
            return !!this.getFieldError(form, field);
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

        async validate(form: string) {
            const yupSchema = useCreateYupSchema(this.validation[form]);
            this.clearAllErrors(form);

            try {
                await yupSchema.validate(this.getValues(form), {abortEarly: false});
            } catch (e: any) {
                e.inner.reverse().forEach((e: ValidationError) => {
                    this.setFieldError(form, e.path ?? '', e.message);
                });
                throw e;
            }
        },

        /**
         * Submit given form
         * @param form
         * @param action
         */
        async submit(form: string, action: string): Promise<any> {
            await this.validate(form);

            try {
                const { post } = useApi();
                const values = this.getValues(form);
                this.setLoading(form, true);

                const res = await post(action, values);
                this.setLoading(form, false);

                return res;
            } catch (e: any) {
                Object.values(e.data.errors).forEach((e: any) => {
                    this.setFieldError(form, e.key ?? '', e.message);
                });
                this.setLoading(form, false);
                throw e;
            }
        }
    }
})