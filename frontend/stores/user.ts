import {bool} from "yup";
import { useCookie } from 'nuxt/app';



export const useUserStore = defineStore('user', {
    state: () => ({
        token: '',
        email: '',
        emailChecked: false,
        emailExists: false,
    }),
    actions: {
        init(session: any) {
            if (session && session.name) {
                console.log('OK2');
                const data = JSON.parse(session.name);

                this.$patch({
                    token: data.token,
                    email: data.email,
                });
            }
        },
        /**
         * Set auth token
         * @param token
         */
        setToken(token: string) {
            console.log('OK1');
            console.log(token);
            this.$patch({
                token: token,
            });
        },

        /**
         * Logout
         */
        logout(): void {
            const session = useCookie('session');
            session.value = '';
            this.$patch({
                token: '',
                email: '',
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