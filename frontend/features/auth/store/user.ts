import {bool} from "yup";
import { useCookie } from 'nuxt/app';

function decodeJWT(token: string) {
    const base64Url = token.split('.')[1];
    const base64 = base64Url.replace(/-/g, '+').replace(/_/g, '/');
    const jsonPayload = decodeURIComponent(
        atob(base64)
            .split('')
            .map((c) => '%' + ('00' + c.charCodeAt(0).toString(16)).slice(-2))
            .join('')
    );

    return JSON.parse(jsonPayload);
}

export const useUserStore = defineStore('user', {
    state: () => ({
        token: '',
        email: '',
        id: '',
        emailChecked: false,
        emailExists: false,
    }),
    actions: {
        init() {
            const tokenCookie = useCookie('token');
            if (tokenCookie && tokenCookie.value) {
                const decoded = decodeJWT(tokenCookie.value);

                this.$patch({
                    token: tokenCookie.value?.toString(),
                    email: decoded.email,
                    id: decoded.id,
                });
            }
        },
        /**
         * Set auth token
         * @param token
         */
        setToken(token: string) {
            const tokenCookie = useCookie('token');
            tokenCookie.value = token;
            const decoded = decodeJWT(tokenCookie.value);

            this.$patch({
                token: tokenCookie.value?.toString(),
                email: decoded.email,
                id: decoded.id,
            });
        },

        /**
         * Logout
         */
        logout(): void {
            const tokenCookie = useCookie('token');
            tokenCookie.value = '';
            this.$patch({
                token: '',
                email: '',
                id: '',
                emailChecked: false,
                emailExists: false,
            });
        },

        /**
         * Set email
         * @param email
         */
        setEmail(email: string) {
            this.$patch({
                email: email,
            });
        },

        /**
         * Check if email already registered
         * @param value
         */
        checkEmail(value: boolean): void {
            this.$patch({
                emailChecked: true,
                emailExists: value,
            });
        },

        /**
         * Is logged in
         */
        isLoggedIn(): boolean {
            return !!this.token;
        },

        /**
         * Get JWT Token
         */
        getToken(): string {
            return this.token;
        },
    }
})