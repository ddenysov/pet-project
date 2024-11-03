// stores/counter.js
import {defineStore} from 'pinia'
import {useApi} from "~/app/shared/api/composables/api";
import {useAsyncData} from "#app";


export const useDatasetStore = defineStore('dataset', {
    /**
     * State
     */
    state: (): any => {
        return {
            track: {
                status: 'success',
                data: [],
            }
        }
    },

    /**
     * Actions
     */
    actions: {
        /**
         * Is loaded
         * @param name
         */
        status(name: string) {
            return this[name]?.status;
        },

        async load(name: string): Promise<void> {
            if (!this[name]) {
                this.$patch({
                    [name]: {
                        status: 'success',
                        data: [],
                    },
                })
            }

            const {get} = useApi();
            const {data, status} = useAsyncData('/api/track/list', async () => {
                const { data, page, records } = await get('/api/track/list');

                this.$patch({
                    [name]: {
                        data,
                        page,
                        records,
                    }
                })

                return data;
            })

            this.$patch({
                [name]: { status },
            })
        },
    },
})