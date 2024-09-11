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
        async get (resource: string) {
            const res: any = await useFetch(
                resource,
                {
                    method: 'GET',
                    headers,
                },
            );

            return res.data.value;
        }
    }
}