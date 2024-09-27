<script setup lang="ts">

import WidgetAvatar from "~/app/widgets/components/navbar/avatar/WidgetAvatar.vue";
import {useAuthStore} from "~/app/shared/auth/store/auth";

const authStore = useAuthStore();
const items = ref([
  {
    label: 'Покатушки',
    command: () => {
      navigateTo('/ride');
    },
  },
  {
    label: 'Клуби',
    command: () => {
      navigateTo('/ride');
    },
  },
  {
    label: 'Маршрути',
    command: () => {
      navigateTo('/ride');
    },
  },
  {
    label: 'О нас',
    command: () => {
      navigateTo('/ride');
    },
  },
]);
const loginFormVisible = ref(false);
const registerFormVisible = ref(false);
</script>

<template>
  <ui-toolbar>
    <template #start>
      <ui-router-link to="/" label="ПЕТ ПРОЄКТ ДФДФДФД" />
      <Menubar
        :model="items"
        :pt="{
          root: {
            class: 'border-none ui-primary',
          },
          itemLabel: {},
        }"
      />
    </template>
    <template #end>
      <ui-button v-if="authStore.isLoggedIn()" class="ml-2" label="Створити покатушку"
                 @click="() => navigateTo('/ride/create')" />
      <ui-button v-if="!authStore.isLoggedIn()" class="ml-2" label="Увійти" @click="() => loginFormVisible = true" />
      <ui-button v-if="!authStore.isLoggedIn()" class="ml-2" label="Реєстрація"
                 @click="() => registerFormVisible = true" />
      <widget-avatar />
    </template>
  </ui-toolbar>
</template>

<style scoped>

</style>