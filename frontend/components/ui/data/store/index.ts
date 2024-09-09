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
        isLoading(data: string): boolean {
            const isLoading = (this.loading[data] && !process.server);

            console.log('XXXXXX');
            console.log(isLoading);
            console.log(this.loading);
            console.log(this.rows.rides.length);

            return this.loading[data] && !process.server && this.rows.rides.length === 0;
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

                const res: any = await useFetch(
                    resource,
                    {
                        method: 'GET',
                        headers: getHeaders(),
                    },
                );


                console.log(data);
                console.log(res.data.value.data);

                this.setRows(data, res.data.value.data);


                this.setLoading(data, false);

                return res;
            } catch (e: any) {
                this.setLoading(data, false);
            }
        }
    }
})