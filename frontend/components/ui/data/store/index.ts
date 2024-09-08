// stores/counter.js
import {defineStore} from 'pinia'


type Value<T> = {
    [value: string]: T;
}

interface Values<T> {
    [data: string]: Value<T>;
}

interface Loading {
    [data: string]: boolean;
}

interface Validation extends Values<{}> {
}

type FormState = {
    rows: {},
    loading: Loading,
}
import {useUserStore} from "~/stores/user";

function getHeaders(): HeadersInit
{
    const store = useUserStore();
    const headers: HeadersInit = {
        'Content-Type': 'application/json',
    };

    if (store.token) {
        headers['Authorization'] = `Bearer ` + store.token;
    }

    return headers;
}

export const useDataStore = defineStore('data', {
    /**
     * State
     */
    state: (): any => {
        return {
            rows: {},
            loading: {},
        }
    },
    /**
     * Actions
     */
    actions: {
        /**
         * Set form loading state
         * @param data
         * @param value
         */
        setLoading(data: string, value: boolean) {
            this.$patch({
                loading: {
                    [data]: value,
                }
            })
        },

        setRows(data: string, rows: any) {
            this.$patch({
                rows: {
                    [data]: rows,
                }
            })
        },

        /**
         *
         * @param data
         */
        getRows(data: string): any {
            return this.rows[data];
        },


        /**
         * Is field loading
         * @param form
         */
        isLoading(form: string): boolean {
            return this.loading[form];
        },

        /**
         * Submit given form
         * @param data
         * @param resource
         */
        async load(data: string, resource: string): Promise<any> {
            try {
                console.log('aasasas');
                this.setLoading(data, true);

                const res: any = await $fetch(
                    resource,
                    {
                        method: 'GET',
                        headers: getHeaders(),
                    },
                );

                this.setRows(data, res.data);
                console.log(data);
                console.log(res.data);

                this.setLoading(data, false);

                return res;
            } catch (e: any) {
                this.setLoading(data, false);
            }
        }
    }
})