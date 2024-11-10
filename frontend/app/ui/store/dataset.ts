import {useAsyncData} from "#app";
import {useApi} from "~/app/shared/api/composables/api";

export const useDatasetStore = (name: string, source: string) => {
    return defineStore(name + 'Dataset', () => {
        console.log('SERVEEEER');

        const page = ref(0);
        const data = ref([]);

        const load = async () => {
            console.log('LOOOAD');
            const res = await $fetch(source + '?page=' + page.value)

            data.value = res.data;

            console.log(res.data);
        }

        const setPage = (value: number) => page.value = value;

        return { load, data }
    })
}
