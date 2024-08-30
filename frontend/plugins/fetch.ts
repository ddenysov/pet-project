export default defineNuxtPlugin((nuxtApp) => {
    nuxtApp.$fetch = async (url: string, options: any = {}) => {
        // Получаем токен (например, из Pinia или локального хранилища)
        const token = useCookie('authToken').value;

        // Добавляем заголовок Authorization с токеном
        if (token) {
            options.headers = {
                ...options.headers,
                Authorization: `Bearer lalalal`,
            };
        }

        console.log('trololo');

        // Используем стандартный $fetch с измененными опциями
        return $fetch(url, options);
    };
});
