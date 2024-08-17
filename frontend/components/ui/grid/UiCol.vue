<script setup lang="ts">
import { computed, defineProps } from 'vue';
import { useClass } from '@/shared/ui-kit/composables/style/class'
import type { Responsive } from '@/shared/ui-kit/types'

type Col = 0 | 1 | 2 | 3 | 4 | 5 | 6 | 7 | 8 | 9 | 10 | 11 | 12;

export interface Props {
  col?: Col | Responsive<Col>
}

const props = withDefaults(defineProps<Props>(), {
  col: 0
})

const computedClass = computed(() => {
  return [
    useClass<Col>('col', props.col === 0 ? '' : props.col),
  ];
});
</script>

<template>
  <div :class="computedClass">
    <slot />
  </div>
</template>
