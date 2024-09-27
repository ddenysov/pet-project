<script setup lang="ts">
import type {MenuProps} from "~/app/ui/types/menu";

defineProps<MenuProps>()
const baseMenu = ref();

const toggle = (event: any) => {
  baseMenu.value.toggle(event);
}

defineExpose({
  toggle,
});

</script>

<template>
  <Menu ref="baseMenu" id="overlay_menu" :model="items" :popup="true" />
</template>

<style scoped>

</style>