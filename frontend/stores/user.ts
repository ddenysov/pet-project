export const useUserStore = defineStore('user', {
    state: () => ({
        token: '',
        email: ''
    }),
    actions: {
        setToken(token: string) {
            this.$patch({
                token: '123',
            })
        }
    }
})