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
            this.$patch({
                token: token,
            });
        },

        /**
         * Logout
         */
        logout(): void {
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
    }
})