import { defineNuxtPlugin } from '#app'
import OpenLayers from 'vue3-openlayers'
import { Map } from 'vue3-openlayers';

export default defineNuxtPlugin(nuxtApp => {
    nuxtApp.vueApp.use(OpenLayers)
    nuxtApp.vueApp.use(Map)
})