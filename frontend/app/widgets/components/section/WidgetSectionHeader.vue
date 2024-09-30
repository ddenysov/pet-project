<script setup lang="ts">
export interface Props {
  title?: string | null,
  subtitle?: string | null,
}

defineProps<Props>();
</script>

<template>
  <ui-section style="height: 200px">
    <div><h1>{{ title }}</h1></div>
    <div><h2>{{ subtitle }}</h2></div>
  </ui-section>
</template>

<style scoped>

</style>