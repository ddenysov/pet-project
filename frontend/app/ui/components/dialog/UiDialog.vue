<script setup lang="ts">
import {defineProps} from "vue";

const visible = ref(false);


const close = () => {
  visible.value = false;
}

const show = () => {
  visible.value = true;
}

defineExpose({
  close,
  show,
});

export interface Props {
  title: string,
}
const props = defineProps<Props>();

</script>

<template>
  <Dialog
    v-model:visible="visible"
    modal
    :header="title"
    @close="close"
  >
    <slot />
  </Dialog>
</template>

<style scoped>

</style>