import { getActivePinia, defineStore } from 'pinia'

const registry: any = {};

export const useDatasetStore = (name: string, source: string, pageSize: number) => {
    if (registry[name]) {
        return registry[name];
    }

    const store = defineStore(name + 'Dataset', () => {
        const page = ref(0);
        const data = ref([]);
        const total = ref(0);
        const loading = ref(false);
        const size = ref(pageSize);

        const load = async () => {
            loading.value = true;
            const res:any = await $fetch(source + '?page=' + page.value + '&size=' + size.value);
            loading.value = false;
            data.value = res.data;
            total.value = res.records.total;
        }

        const clear = async () =>{
            data.value = [];
        }

        const init = async () => {
            if (data.value.length === 0) {
                await load();
            }
        }

        const setPage = (value: number) => page.value = value;

        watch(
            () => page.value,
            () => load(),
        );

        return { load, data, loading, init, setPage, page, clear, total }
    })

    registry[name] = store;

    return store;
}
