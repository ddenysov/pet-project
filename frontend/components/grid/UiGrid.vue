<script setup lang="ts">
import { computed, defineProps } from 'vue';
import { useBooleanClass } from '@/shared/ui-kit/composables/style/class'

export interface Props {
  noGutter?: boolean
}

const props = defineProps<Props>();

const computedClass = computed(() => {
  return [
    useBooleanClass('grid-nogutter', props.noGutter),
  ];
});
</script>

<template>
  <div class="grid grid-nogutter" :class="computedClass">
    <slot />
  </div>
</template>
