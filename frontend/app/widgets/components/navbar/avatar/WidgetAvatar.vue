<script setup lang="ts">
const toggle = (event: any) => {
  menu.value.toggle(event);
};
const menu = ref();
const menuItems = ref([
  {
    label: 'Профіль',
    items: [
      {
        label: 'Вийти',
        icon: 'pi pi-sign-out',
      }
    ]
  }
]);
</script>

<template>
  <ui-menu ref="menu" :items="menuItems" id="overlay_menu" />
  <Avatar @click="toggle" label="DD" class="mr-2 cursor-pointer" size="medium" shape="circle" />
</template>

<style scoped>

</style>