<script setup lang="ts">
export interface Props {
  title?: string | null,
}

defineProps<Props>();
</script>

<template>
  <ui-flex style="width: 100%" direction="column">
    <div><h2 class="ui-text-primary">{{ title }}</h2></div>
    <div>
      <slot />
    </div>
  </ui-flex>
</template>

<style scoped>

</style>