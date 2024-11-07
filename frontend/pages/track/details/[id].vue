<script setup lang="ts">
import {useApi} from "~/app/shared/api/composables/api";

definePageMeta({
  menu: 'track',
})
const route = useRoute()

const {get} = useApi();

const res = await get('/api/track/details/' + route.params.id);

console.log(res);

</script>

<template>
  <div>
    {{ route.params.id }}
    <ui-map-track-viewer :path="JSON.parse(res?.data.path)" />
  </div>
</template>

<style scoped>

</style>