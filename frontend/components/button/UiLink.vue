<script setup lang="ts">
import Button from 'primevue/button';
import { defineProps } from 'vue'
import type { ButtonProps } from '@/shared/ui-kit/types/button'

defineProps<ButtonProps>();
</script>

<template>
  <Button
    :label="label"
    link
  />
</template>

<style scoped>

</style>