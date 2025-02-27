import {useAuth} from "./auth";

export function useApi () {
    const {addAuthHeaders} = useAuth();

    const headers: HeadersInit = {
        'Content-Type': 'application/json',
    };
    addAuthHeaders(headers)

    return {
        /**
         * Get request
         * @param resource
         */
        getAsync (resource: string) {
            return useFetch(
                resource,
                {
                    method: 'GET',
                    headers,
                },
            );
        },

        /**
         * Get
         * @param resource
         */
        async get (resource: string) {
            const res: any = await $fetch(
                resource,
                {
                    method: 'GET',
                    headers,
                },
            );

            return res;
        },

        /**
         * Post request
         * @param resource
         * @param data
         */
        async postAsync (resource: string, data: any) {
            const res: any = await useFetch(
                resource,
                {
                    method: 'POST',
                    body: JSON.stringify(data),
                    headers,
                },
            );

            return res.data.value;
        },

        /**
         *
         * @param resource
         * @param data
         */
        async post (resource: string, data?: any) {
            const res: any = await $fetch(
                resource,
                {
                    method: 'POST',
                    body: JSON.stringify(data),
                    headers,
                },
            );

            return res;
        },
    }
}