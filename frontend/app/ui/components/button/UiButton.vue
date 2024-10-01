<script setup lang="ts">
import type {ButtonProps} from "~/app/ui/types/button";

const props = defineProps<ButtonProps>()
</script>

<template>
  <Button
    class="ui-button"
    :label="label"
    :class="{
      accent: props.color === 'accent',
      primary: props.color === 'primary',
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

  &.primary {
    background-color: var(--p-primary-color);
    color: var(--p-primary-contrast-color);
    border-color: var(--p-primary-color);
    &:hover {
      background-color: var(--p-primary-hover-color);
      border-color: var(--p-primary-hover-color);
    }
    &:active {
      background-color: var(--p-primary-active-color);
    }
  }
}
</style>