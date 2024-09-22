<script setup lang="ts">
import {defineProps} from "vue";

const visible = ref(false);


const close = () => {
  visible.value = false;
}

const show = () => {
  visible.value = true;
}

</script>

<template>
  <Dialog
    style="width: 90%; height: 600px"
    v-model:visible="visible"
    modal
    header="Реєстрація"
    @close="close"
  >
    <slot />
  </Dialog>
</template>

<style scoped>

</style>