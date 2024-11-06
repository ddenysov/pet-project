<script setup lang="ts">
definePageMeta({
  menu: 'track',
})
const route = useRoute()
</script>

<template>
  <div>
    {{ route.params.id }}
  </div>
</template>

<style scoped>

</style>