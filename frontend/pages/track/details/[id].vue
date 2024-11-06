<script setup lang="ts">
import {useApi} from "~/app/shared/api/composables/api";

definePageMeta({
  menu: 'track',
})
const route = useRoute()

const {get} = useApi();

const res = await get('/api/track/details/2fe13623-e592-4c7a-bca4-8d97e1d7c3fb');

console.log(res);

</script>

<template>
  <div>
    {{ route.params.id }}
  </div>
</template>

<style scoped>

</style>