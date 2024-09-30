<script setup lang="ts">

import WidgetAvatar from "~/app/widgets/components/navbar/avatar/WidgetAvatar.vue";
import {useAuthStore} from "~/app/shared/auth/store/auth";
import FeatureRegister from "~/app/features/register/FeatureRegister.vue";

const authStore = useAuthStore();
const items = ref([
  {
    label: 'Головна',
    command: () => {
      navigateTo('/');
    },
  },
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
      navigateTo('/about');
    },
  },
]);
const loginFormVisible = ref(false);
const registerFormVisible = ref(false);
</script>

<template>
  <ui-toolbar>
    <template #start>
      <img style="position: absolute; top: 4px; left: 0" src="/images/logo2.png" width="160" />
      <div style="width: 140px"></div>

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
      <ui-button style="padding: 10px 20px;margin-right: 12px; background-color:  var(--p-amber-500);" v-if="authStore.isLoggedIn()" class="ml-2" label="+ Додати"
                 @click="() => navigateTo('/ride/create')" />
      <ui-button color="primary" v-if="!authStore.isLoggedIn()" class="ml-2" label="Увійти" @click="() => loginFormVisible = true" />
      <feature-register />
      <widget-avatar />
    </template>
  </ui-toolbar>
</template>

<style scoped>

</style>