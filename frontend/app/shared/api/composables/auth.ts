export function useAuth() {
    const tokenCookie = useCookie('token')

    return {
        addAuthHeaders (headers: any) {
            if (tokenCookie.value) {
                headers['Authorization'] = `Bearer ` + tokenCookie.value;
            }

            return headers;
        },
        getHeader () {
            const res = {
                key: '',
                value: '',
            }
            if (tokenCookie.value) {
                res.key = 'Authorization';
                res.value = `Bearer ` + tokenCookie.value;
            }

            return res;
        }
    }
}