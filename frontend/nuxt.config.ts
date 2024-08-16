// https://nuxt.com/docs/api/configuration/nuxt-config
import Aura from '@primevue/themes/aura';
export default defineNuxtConfig({
    compatibilityDate: '2024-04-03',
    devtools: {enabled: true},
    modules: [
        "@pinia/nuxt",
        '@primevue/nuxt-module'
    ],
    primevue: {
        autoImport: false,
        components: {
            include: [
                'DatePicker',
                'Select',
                'Menu',
                'ProgressBar',
                'Button',
                'IconField',
                'InputIcon',
                'InputText',
            ],
        },
        options: {
            theme: {
                preset: Aura
            }
        },
    },
})