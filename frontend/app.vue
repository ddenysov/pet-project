<template>
  <NuxtLayout>
    <NuxtPage />
  </NuxtLayout>
</template>

<script setup lang="ts">
import 'primeicons/primeicons.css'
import '/node_modules/primeflex/primeflex.css';
import '/node_modules/primeflex/themes/primeone-dark.scss';
import '~/assets/scss/app.scss';
import {useUserStore} from "~/stores/user";
const tokenCookie = useCookie('token')
const userStore = useUserStore();
userStore.init();
const { $listen } = useNuxtApp()

$listen('*', (type, e) => console.log(type, e) )

// fire an event
</script>