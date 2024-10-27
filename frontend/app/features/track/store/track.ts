import {array} from "yup";

export const useCreateTrackStore = defineStore('auth', {
    state: () => ({
        path: array,
        name: String,
    }),
    actions: {
        save () {

        },
    }
})