export function useAuth() {
    const tokenCookie = useCookie('token')

    return {
        addAuthHeaders (headers: any) {
            if (tokenCookie.value) {
                headers['Authorization'] = `Bearer ` + tokenCookie.value;
            }

            return headers;
        },
    }
}