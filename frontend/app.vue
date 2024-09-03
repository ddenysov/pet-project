<template>
  <NuxtLayout>
    <NuxtPage />
  </NuxtLayout>
</template>

<script setup lang="ts">
import 'primeicons/primeicons.css'
import '/node_modules/primeflex/primeflex.css';
import {useUserStore} from "~/stores/user";
const tokenCookie = useCookie('token')

console.log('session');
console.log(tokenCookie.value);

const userStore = useUserStore();
userStore.init();


</script>