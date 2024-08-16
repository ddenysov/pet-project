<script setup lang="ts">
import { computed, defineProps } from 'vue';

import { useBooleanClass, useClass } from '@/shared/ui-kit/composables/style/class'
import type { Responsive } from '@/shared/ui-kit/types'

type AlignItems = 'stretch' | 'start' | 'center' | 'baseline' | 'end';
type JustifyContent = 'between' | 'start' | 'center' | 'around' | 'end' | 'evenly';
type Bit = '0' | '1';
type Gap = 1 | 2 | 3 | 4 | 5 | 6 | 7 | 8;
type Direction = 'row' | 'column';

export interface Props {
  grow?: Bit | Responsive<Bit>
  shrink?: Bit | Responsive<Bit>
  alignItems?: AlignItems | Responsive<AlignItems>
  justifyContent?: JustifyContent | Responsive<JustifyContent>
  direction?: Direction | Responsive<Direction>
  gap?: Gap | Responsive<Gap>
  fullHeight?: boolean,
}

const props = defineProps<Props>();

const computedClass = computed(() => {
  return [
    useClass<Bit>('flex-grow', props.grow),
    useClass<Bit>('flex-shrink', props.shrink),
    useClass<AlignItems>('align-items', props.alignItems),
    useClass<JustifyContent>('justify-content', props.justifyContent),
    useClass<Direction>('flex', props.direction),
    useClass<Gap>('gap', props.gap),
    useBooleanClass('ui-full-height', props.fullHeight),
  ];
});
</script>

<template>
  <div class="flex" :class="computedClass">
    <slot />
  </div>
</template>
