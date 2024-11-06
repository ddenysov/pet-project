import {useAsyncData} from "#app";
import {useApi} from "~/app/shared/api/composables/api";

export const useDatasetStore = defineStore('dataset', () => {
    const {get} = useApi();
    const dataset = ref([]);

    const load = async () => {
        useAsyncData('track', async (id) => {
            const { data } = await get('/api/track/details/' + id);
        })
    }

    return { dataset, load }
})