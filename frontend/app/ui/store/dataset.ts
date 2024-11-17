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
        const sortOrderBy = ref(null);
        const sortOrderDir = ref(null);

        function objectToQueryString(params) {
            return Object.keys(params)
                .filter(key => !!params[key])
                .map(key => encodeURIComponent(key) + '=' + encodeURIComponent(params[key]))
                .join('&');
        }

        const load = async () => {
            const query = objectToQueryString({
                page: page.value,
                size: size.value,
                orderBy: sortOrderBy.value ?? '',
                orderDir: sortOrderDir.value ?? '',
            })
            loading.value = true;
            const res:any = await $fetch(source + '?' + query);
            loading.value = false;
            data.value = res.data;
            total.value = res.records.total;
        }

        const clear = async () =>{
            data.value = [];
        }

        const init = async ( { pageSize, defaultSortOrderBy, defaultSortOrderDir } ) => {
            if (pageSize) {
                size.value = pageSize;
            }
            if (defaultSortOrderBy) {
                sortOrderBy.value = defaultSortOrderBy;
            }
            if (defaultSortOrderDir) {
                sortOrderDir.value = defaultSortOrderDir;
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

        return { load, data, loading, init, setPage, page, clear, total, size, sortOrderBy, sortOrderDir }
    })

    registry[name] = store;

    return store;
}
