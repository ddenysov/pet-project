<template>
  <NuxtLayout>
    <NuxtPage />
  </NuxtLayout>
</template>

<script setup lang="ts">
import 'primeicons/primeicons.css'
import '/node_modules/primeflex/primeflex.css';
import {useUserStore} from "~/stores/user";
const session = useCookie<{ name: string }>('session')

console.log('session');
console.log(session.value.name);

const userStore = useUserStore();
userStore.init(session.value);


</script>