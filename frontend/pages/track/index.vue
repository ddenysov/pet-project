<script setup lang="ts">
import WidgetPublicTracks from "~/app/widgets/track/public-tracks/components/WidgetPublicTracks.vue";

definePageMeta({
  menu: 'track',
})
</script>

<template>
  <div>
    <h1>Список Маршрутів</h1>
    <widget-public-tracks />
  </div>
</template>

<style scoped>

</style>