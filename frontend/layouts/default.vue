<script setup lang="ts">
import {useUserStore} from "~/stores/user";
import {useMessageStore} from "~/components/ui/message/store";
const store = useUserStore();
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
          store.logout()
        }
      }
    ]
  }
]);
const visible = ref(false);
const toggle = (event: any) => {
  menu.value.toggle(event);
};

const userStore = useUserStore();
const onLoginSuccess = async (res: any) => {
  userStore.setToken(res.res.token);
  visible.value = false;
}
</script>

<template>
  <div>
    <ui-toolbar>
      <template #start>
        <ui-nav-link to="/" label="ПЕТ ПРОЄКТ" />
        <Menubar style="border: none" :model="items" />
      </template>
      <template #end>
        <Avatar v-if="store.isLoggedIn()" @click="toggle" label="P" class="mr-2 cursor-pointer" size="large" shape="circle" />
        <Menu ref="menu" id="overlay_menu" :model="menuItems" :popup="true" />
        <ui-button v-if="store.isLoggedIn()" class="ml-2" label="Створити покатушку" @click="() => navigateTo('/ride/create')" />
        <ui-button v-if="!store.isLoggedIn()" class="ml-2" label="Увійти" @click="() => visible = true" />
      </template>
    </ui-toolbar>
    <ui-message name="layout" />
    <ui-nav-link v-if="!store.isLoggedIn()" to="/login" label="Увійти" />
    <ui-nav-link v-if="!store.isLoggedIn()" to="/register" label="Реєстрація" />
    <slot />


    <Dialog v-model:visible="visible" modal header="Увійти" :style="{ width: '25rem' }">
      <ui-flex grow="1" direction="column">
        <ui-text-field
          form="login"
          label="Електронна пошта"
          name="email"
          :validation="{ required: true, email: true }"
        />

        <ui-text-field
          form="login"
          label="Пароль"
          name="password"
        />

        <ui-submit-button
          class="mt-2"
          action="/api/iam/login"
          form="login"
          label="Увійти"
          name="submit"
          @submit="onLoginSuccess"
        />
      </ui-flex>
    </Dialog>
  </div>
</template>

<style scoped>

</style>