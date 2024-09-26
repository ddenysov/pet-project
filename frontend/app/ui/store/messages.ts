// stores/counter.js
import {defineStore} from 'pinia'


export const useMessageStore = defineStore('messages', {
    /**
     * State
     */
    state: (): any => {
        return {
            messages: {},
            visible: {},
        }
    },

    /**
     * Actions
     */
    actions: {
        /**
         * Set Rows
         * @param name
         * @param message
         */
        showMessage(name: string, message: string) {
            this.$patch({
                messages: {
                    [name]: message,
                }
            })
        },

        /**
         * Clear message
         * @param name
         */
        clearMessage(name: string) {
            this.$patch({
                messages: {
                    [name]: '',
                }
            })
        },

        /**
         * Get message
         * @param name
         */
        getMessage(name: string) {
            return this.messages[name];
        },
    },
})