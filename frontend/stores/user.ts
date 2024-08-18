export const useUserStore = defineStore('user', {
    state: () => ({
        token:  '',
        email: '',
        emailChecked: false,
        emailExists: false,
    }),
    actions: {
        init () {
            if (document) {
                const storedToken = localStorage.getItem('token') ?? '';
                this.$patch({
                    token: storedToken,
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
            localStorage.setItem('token', token);
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