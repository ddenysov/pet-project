// stores/counter.js
import {defineStore} from 'pinia'
import {useApi} from "~/composables/api/api";

type Value<T> = {
    [value: string]: T;
}

interface Values<T> {
    [data: string]: Value<T>;
}

interface Loading {
    [data: string]: boolean;
}

interface Input {
    [data: string]: {
        start: number,
        length: number,
        sortColumn: string,
        sortOrder: string,
    }
}

interface Rows {
    [data: string]: any
}

type DataSetState = {
    rows: Rows,
    loading: Loading,
    input: Input,
}

export const useDataStore = defineStore('data', {
    /**
     * State
     */
    state: (): DataSetState => {
        return {
            rows: {},
            loading: {},
            input: {},
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

        /**
         * Set Rows
         * @param data
         * @param rows
         */
        setRows(data: string, rows: any) {
            this.$patch({
                rows: {
                    [data]: rows,
                }
            })
        },

        /**
         * Get rows
         * @param data
         */
        getRows(data: string): any {
            return this.rows[data];
        },

        /**
         * Is field loading
         * @param data
         */
        isLoading(data: string): boolean {
            return this.loading[data] && !process.server;
        },

        /**
         * Load data
         * @param data
         * @param resource
         */
        async load(data: string, resource: string): Promise<any> {
            try {
                this.setLoading(data, true);
                const {get} = useApi();
                const res: any = await get(resource);
                this.setRows(data, res.data);
                this.setLoading(data, false);

                return res;
            } catch (e: any) {
                this.setLoading(data, false);
            }
        }
    }
})