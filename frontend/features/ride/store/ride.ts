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

export const useRideStore = defineStore('ride', {
    /**
     * State
     */
    state: (): any => {
        return {
            ride: {},
            loading: false,
        }
    },
    /**
     * Actions
     */
    actions: {
        /**
         * Set loading
         * @param value
         */
        setLoading(value: boolean) {
            this.$patch({
                loading: value
            })
        },

        /**
         * Set ride
         * @param ride
         */
        setRide(ride: any) {
            this.$patch({
                ride: ride,
            })
        },

        /**
         * Is field loading
         * @param form
         */
        isLoading(): boolean {
            return this.loading;
        },

        /**
         * Load ride
         * @param id
         */
        async load(id: string): Promise<any> {
            try {
                this.setRide({});
                this.setLoading(true);

                const res: any = await useFetch(
                    '/api/ride/view-ride/' + id,
                    {
                        method: 'GET',
                        headers: getHeaders(),
                    },
                );
                console.log('ok2');
                console.log(res.data.value);
                this.setRide(res.data.value);
                this.setLoading(false);

                return res;
            } catch (e: any) {
                console.error(e);
                this.setLoading(false);
            }
        },

        async join(id: string): Promise<any> {
            try {
                this.setLoading(true);
                const { post } = useApi();

                const res: any = await post('/api/ride/join-ride/' + id);
                console.log(res.data);
                this.setLoading(false);

                return res;
            } catch (e: any) {
                console.error(e);
                this.setLoading(false);
            }
        }
    }
})