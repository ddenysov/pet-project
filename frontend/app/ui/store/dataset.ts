import { getActivePinia, defineStore } from 'pinia'

const registry: any = {};

export const useDatasetStore = (name: string, source?: string) => {
    if (registry[name]) {
        return registry[name];
    }

    const store = defineStore(name + 'Dataset', () => {
        const page = ref(0);
        const data = ref([]);
        const total = ref(0);
        const loading = ref(false);
        const size = ref(5);

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

        const init = async ( pageSize?: number) => {
            if (pageSize) {
                size.value = pageSize;
            }
            if (data.value.length === 0) {
                await load();
            }
        }

        const setPage = (value: number) => page.value = value;

        watch(
            () => page.value,
            () => load(),
        );

        return { load, data, loading, init, setPage, page, clear, total, size }
    })

    registry[name] = store;

    return store;
}
