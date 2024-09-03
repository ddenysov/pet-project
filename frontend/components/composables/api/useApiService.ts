import { useFetch } from 'nuxt/app';
import type { UseFetchOptions } from 'nuxt/app';

interface FetchDataOptions<T> extends UseFetchOptions<T> {
    method?: 'GET' | 'POST' | 'PUT' | 'PATCH' | 'DELETE';
    params?: Record<string, any>;
    body?: any;
}

const initialHeaders: HeadersInit = {
    'Content-Type': 'application/json',
};

const userStore = useUserStore();

/**
 * Get headers
 */
function getHeaders(): HeadersInit
{
    const headers: HeadersInit = {
        'Content-Type': 'application/json',
    };

    if (true) {
        headers['Authorization'] = `Bearer OLOLO`;
    }

    return headers;
}

export function useApi() {
    /**
     * Post request
     * @param url
     * @param data
     */
    const post = async (url: string, data: any): Promise<void> => {
        try {
            await $fetch(
                url,
                {
                    method: 'POST',
                    body: JSON.stringify(data),
                    headers: getHeaders(),
                },
            );
        } catch (err) {
            console.error(`API request failed: ${err}`);
            throw err;
        }
    };

    /**
     * Get request
     * @param url
     * @param data
     */
    const get = async (url: string, data: any): Promise<void> => {
        try {
            await $fetch(
                url,
                {
                    method: 'GET',
                    headers: getHeaders(),
                },
            );
        } catch (err) {
            console.error(`API request failed: ${err}`);
            throw err;
        }
    };

    return {
        /**
         * Run query
         * @param url
         * @param data
         */
        query: async (url: string, data?: Array<string>) => {
            return await get(url, data);
        },

        /**
         * Execute command
         * @param url
         * @param data
         */
        command: async (url: string, data?: any) => {
            return await post(url, data);
        },
    }
}

export function useApiService2() {
    const baseUrl = useRuntimeConfig().public.apiBaseUrl || 'https://api.example.com';

    const authStore = useAuthStore();

    // Универсальная функция для выполнения запроса
    const fetchData = async <T>(url: string, options: any) => {
        const headers: HeadersInit = {
            'Content-Type': 'application/json',
        };

        if (authStore.token) {
            headers['Authorization'] = `Bearer ${authStore.token}`;
        }

        try {
            const { data, error } = await useFetch<T>(
                url,
                options,
            );

            if (error.value) {
                if (error.value.response?.status === 401) {
                    authStore.logout(); // Выход из системы при ошибке авторизации
                }
                throw error.value;
            }

            return data.value;
        } catch (err) {
            console.error(`API request failed: ${err}`);
            throw err;
        }
    };

    return {
        get: <T>(resource: string, params?: Record<string, any>) =>
            fetchData<T>(resource, { method: 'GET', params }),

        post: <T>(resource: string, body?: any) =>
            fetchData<T>(resource, { method: 'POST', body: JSON.stringify(body) }),

        put: <T>(resource: string, body?: any) =>
            fetchData<T>(resource, { method: 'PUT', body: JSON.stringify(body) }),

        patch: <T>(resource: string, body?: any) =>
            fetchData<T>(resource, { method: 'PATCH', body: JSON.stringify(body) }),

        delete: <T>(resource: string) => fetchData<T>(resource, { method: 'DELETE' }),

        // Пример метода для загрузки файлов
        upload: <T>(resource: string, file: File, onUploadProgress?: (progressEvent: ProgressEvent) => void) => {
            const formData = new FormData();
            formData.append('file', file);

            return fetchData<T>(resource, {
                method: 'POST',
                body: formData,
                headers: { 'Content-Type': 'multipart/form-data' },
            });
        },

        // Пример метода для повторов запросов
        retryRequest: <T>(originalRequest: FetchDataOptions<T> & { url: string }) =>
            fetchData<T>(originalRequest.url, originalRequest),
    };
}