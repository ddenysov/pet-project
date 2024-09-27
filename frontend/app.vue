<template>
  <NuxtLayout>
    <NuxtPage />
  </NuxtLayout>
</template>

<script setup lang="ts">
import 'primeicons/primeicons.css'
import '/node_modules/primeflex/primeflex.css';
import '/node_modules/primeflex/themes/primeone-light.scss';
import '~/assets/scss/app.scss';
import {useAuthStore} from "~/app/shared/auth/store/auth";

const authStore = useAuthStore();
authStore.init();

// fire an event
</script>