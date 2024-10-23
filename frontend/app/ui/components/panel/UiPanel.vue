<script setup lang="ts">
import {defineProps} from "vue";

export interface Props {
  color?: string,
}

const props = withDefaults(defineProps<Props>(), {
  color: 'light',
})
</script>

<template>
  <div :class="{
    'ui-panel-light': color === 'light',
    'ui-panel-dark': color === 'dark',
   }">
    <slot />
  </div>
</template>

<style scoped>
  .ui-panel-dark {
    border: var(--p-surface-300) 1px solid;
    background-color: var(--p-surface-100);
    border-radius: 0.5rem;
  }

  .ui-panel-light {
    border: var(--p-surface-200) 1px solid;
    background-color: white;
    border-radius: 0.5rem;
  }
</style>