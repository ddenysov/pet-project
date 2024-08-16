<script setup lang="ts">
import Button from 'primevue/button'
import { defineProps, defineEmits } from 'vue'
import type { ButtonProps } from '@/shared/ui-kit/types/button'

defineEmits(['click'])
defineProps<ButtonProps>()
</script>

<template>
  <Button
    :severity="color"
    :label="label"
    @click="() => $emit('click')"
  />
</template>
