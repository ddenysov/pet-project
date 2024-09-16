// stores/counter.js
import {defineStore} from 'pinia'
import {useApi} from "~/composables/api/api";
import type {DataSetState} from "~/components/ui/data/store/types";


export const useDataStore = defineStore('data', {
    /**
     * State
     */
    state: (): DataSetState => {
        return {
            rows: {},
            loading: {},
            input: {},
            settings: {},
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

        setResource(data: string, resource: string) {
            this.$patch({
                settings: {
                    [data]: {
                        resource: resource,
                    },
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
            return this.loading[data];
        },

        /**
         * Find data by id
         * @param data
         * @param id
         */
        find(data: string, id: string): any {
            return this.rows[data].find((d: any) => d.id === id);
        },


        /**
         * Load data
         * @param data
         */
        async load(data: string): Promise<any> {
            try {
                this.setLoading(data, true);
                const {getAsync, get} = useApi();
                const res: any = await getAsync(this.settings[data].resource);

                this.setRows(data, res.data);
                this.setLoading(data, false);

                return res;
            } catch (e: any) {
                this.setLoading(data, false);
            }
        },


        /**
         * Init
         * @param data
         * @param resource
         */
        async init(data: string, resource: string): Promise<any> {
            this.setResource(data, resource);
            if (!this.getRows(data)) {
                await this.load(data);
            }
        }
    },
})