import {useUserStore} from "~/stores/user";

export function useAuth() {
    const store = useUserStore();

    return {
        addAuthHeaders (headers: any) {
            const store = useUserStore();

            if (store.token) {
                headers['Authorization'] = `Bearer ` + store.token;
            }

            return headers;
        },
    }
}