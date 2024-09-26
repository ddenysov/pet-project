<script setup lang="ts">
import {useAuthStore} from "~/app/shared/auth/store/auth";
const authStore = useAuthStore();
const items = ref([
  {
    label: 'Покатушки',
    command: () => {
      navigateTo('/ride');
    }
  },
]);

const menu = ref();
const menuItems = ref([
  {
    label: 'Профіль',
    items: [
      {
        label: 'Вийти',
        icon: 'pi pi-sign-out',
        command: () => {
          authStore.logout()
        }
      }
    ]
  }
]);
const visible = ref(false);
const rvisible = ref(false);
const toggle = (event: any) => {
  menu.value.toggle(event);
};

const onLoginSuccess = async (res: any) => {
  authStore.setToken(res.res.token);
  visible.value = false;
}


const onRegisterSuccess = (res: any) => {
  rvisible.value = false;
}

</script>

<template>
  <div>
    <ui-toolbar>
      <template #start>
        <ui-router-link to="/" label="ПЕТ ПРОЄКТ" />
        <Menubar style="border: none" :model="items" />
      </template>
      <template #end>
        <Avatar v-if="authStore.isLoggedIn()" @click="toggle" label="P" class="mr-2 cursor-pointer" size="large" shape="circle" />
        <Menu ref="menu" id="overlay_menu" :model="menuItems" :popup="true" />
        <ui-button v-if="authStore.isLoggedIn()" class="ml-2" label="Створити покатушку" @click="() => navigateTo('/ride/create')" />
        <ui-button v-if="!authStore.isLoggedIn()" class="ml-2" label="Увійти" @click="() => visible = true" />
        <ui-button v-if="!authStore.isLoggedIn()" class="ml-2" label="Реєстрація" @click="() => rvisible = true" />
      </template>
    </ui-toolbar>
    <slot />
  </div>
</template>

<style scoped>

</style>