// ~/stores/auth.ts

import { defineStore } from 'pinia';
import { ref } from 'vue';
import { useCookie } from 'nuxt/app';

export const useAuthStore = defineStore('auth', () => {
    const token = ref<string | null>(null);
    const user = ref<{ id: number; name: string; email: string } | null>(null);
    const isAuthenticated = ref<boolean>(false);

    // Используем cookies для хранения токена на сервере и клиенте
    const tokenCookie = useCookie('authToken');

    function login(newToken: string, userData: { id: number; name: string; email: string }) {
        token.value = newToken;
        user.value = userData;
        isAuthenticated.value = true;
        saveToken(newToken);
    }

    function logout() {
        token.value = null;
        user.value = null;
        isAuthenticated.value = false;
        removeToken();
    }

    function saveToken(newToken: string) {
        // Сохраняем токен в cookie, что доступно как на сервере, так и на клиенте
        tokenCookie.value = newToken;
    }

    function removeToken() {
        // Удаляем токен из cookie
        tokenCookie.value = null;
    }

    function loadToken() {
        // Загружаем токен из cookie
        if (tokenCookie.value) {
            token.value = tokenCookie.value;
            isAuthenticated.value = true;
        }
    }

    // Вызвать загрузку токена при загрузке store
    loadToken();

    return {
        token,
        user,
        isAuthenticated,
        login,
        logout,
    };
});
