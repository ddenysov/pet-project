// https://nuxt.com/docs/api/configuration/nuxt-config
import Aura from '@primevue/themes/aura';
import Lara from '@primevue/themes/lara';
import Nora from '@primevue/themes/nora';
import {MainPreset} from "./theme/main.js";
export default defineNuxtConfig({
    compatibilityDate: '2024-04-03',
    devtools: {
      enabled: true,

      timeline: {
        enabled: true,
      },
    },
    vite: {
        css: {
            preprocessorOptions: {
                scss: {
                    api: 'modern-compiler' // or "modern"
                }
            }
        }
    },
    modules: [
      "@pinia/nuxt",
      '@primevue/nuxt-module',
      '@nuxt-alt/proxy',
      '@vesp/nuxt-fontawesome',
    ],
    fontawesome: {
        icons: {
            solid: ['dollar-sign', 'cog', 'circle', 'check', 'calendar-days'],
            regular: ['user']
        }
    },
    components: [
        {
            path: '~/app/ui/components',
            pathPrefix: false,
        },
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
                'Image',
                'Card',
                'Skeleton',
                'DataView',
                'Paginator',
                'Toast',
                'Message',
                'Toolbar',
                'Menubar',
                'Avatar',
                'Dialog',
                'DatePicker',
                'Divider',
                'Textarea',
                'ToggleButton',
                'FileUpload',
                'Breadcrumb',
                'Popover',
                'SplitButton',
            ],
        },
        options: {
            theme: {
                preset: MainPreset,
                options: {
                    darkModeSelector: 'light',
                },
            }
        },
    },
    routeRules: {
        '/api/iam/**': {
            proxy: { to: "http://localhost:8000/iam/**", },
        },
        '/api/ride/**': {
            proxy: { to: "http://localhost:8000/ride/**", },
        },
        '/api/media/**': {
            proxy: { to: "http://localhost:8000/media/**", },
        },
    },
})