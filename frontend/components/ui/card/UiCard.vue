<script setup lang="ts">
export interface Props {
  header: string | null,
  title: string | null,
  subtitle: string | null,
  content: string | null,
  footer: string | null,
}

defineProps<Props>();
</script>

<template>
  <Card>
    <template #header>
      <slot name="header">{{ header }}</slot>
    </template>
    <template #title>
      <slot name="title">{{ title }}</slot>
    </template>
    <template #subtitle>
      <slot name="subtitle">{{ subtitle }}</slot>
    </template>
    <template #content>
      <slot name="content">{{ content }}</slot>
    </template>
    <template #footer>
      <slot name="footer">{{ footer }}</slot>
    </template>
  </Card>
</template>

<style scoped>

</style>