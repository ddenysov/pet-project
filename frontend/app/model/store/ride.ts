// stores/counter.js
import {defineStore} from 'pinia'
import {useApi} from "~/app/shared/api/composables/api";


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

                const {get} = useApi();

                const res: any = await get('/api/ride/view-ride/' + id);
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