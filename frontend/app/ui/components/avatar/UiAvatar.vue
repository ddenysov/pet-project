<script setup lang="ts">
export interface Props {
  image?: string | null,
}

defineProps<Props>();
</script>

<template>
  <Avatar :image="image" size="xlarge" shape="circle" />
</template>
