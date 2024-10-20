<script setup lang="ts">
import {useAuthStore} from "~/app/shared/auth/store/auth";

const authStore = useAuthStore();

const toggle = (event: any) => {
  menu.value.toggle(event);
};
const menu = ref();
const menuItems = ref([
  {
    label: 'Профіль',
    items: [
      {
        label: 'Дешборд',
        icon: 'pi pi-sign-out',
      },
      {
        label: 'Вийти',
        icon: 'pi pi-sign-out',
      }
    ]
  }
]);
</script>

<template>
  <div v-if="authStore.isLoggedIn()">
    <ui-menu ref="menu" :items="menuItems" id="overlay_menu" />
    <Avatar @click="toggle" label="DD" class="mr-2 cursor-pointer" size="medium" shape="circle" />
  </div>
</template>

<style scoped>

</style>