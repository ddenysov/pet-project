<script setup lang="ts">
import type {ButtonProps} from "~/app/ui/types/button";

const props = defineProps<ButtonProps>()
</script>

<template>
  <Button
    class="ui-button"
    :label="label"
    :class="{
      accent: props.color === 'accent'
    }"
  />
</template>

<style scoped>
.ui-button {
  &.accent {
    background-color: var(--p-accent-color);
    color: var(--p-accent-contrast-color);
    border-color: var(--p-accent-color);
    &:hover {
      background-color: var(--p-accent-hover-color);
      border-color: var(--p-accent-hover-color);
    }
    &:active {
      background-color: var(--p-accent-active-color);
    }
  }

}
</style>