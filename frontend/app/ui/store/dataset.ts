// stores/counter.js
import {defineStore} from 'pinia'
import {useApi} from "~/app/shared/api/composables/api";
import type {DataSetState} from "~/app/ui/types/data";
import {useAsyncData} from "#app";


export const useDatasetStore = defineStore('dataset', {
    /**
     * State
     */
    state: (): any => {
        return {
            data: null,
            page: null,
            status: null,
        }
    },
    /**
     * Actions
     */
    actions: {
        async load(name: string): Promise<void> {
            const {getAsync} = useApi();

            console.log('LOAD');

            const {data, status} = await useAsyncData('/api/track/list', async () => {
                const { data, page } = await $fetch('/api/track/list');

                this.$patch({
                    data,
                    page,
                })

                return data;
            })

            this.$patch({
                status: status,
            })
        },
    },
})