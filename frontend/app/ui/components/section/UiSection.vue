<script setup lang="ts">
import {defineProps} from "vue";

type AlignItems = 'stretch' | 'start' | 'center' | 'baseline' | 'end';


const props = withDefaults(defineProps<Props>(), {
  align: 'start' as AlignItems, // Set default value here
});
export interface Props {
  align: AlignItems,
}
</script>

<template>
  <ui-flex
    :align-items="align"
    justify-content="center"
    direction="column"
  >
    <slot />
  </ui-flex>
</template>

<style scoped>

</style>