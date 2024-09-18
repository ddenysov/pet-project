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

if (process.client) {
  const url = new URL('http://localhost:3010/.well-known/mercure');
  url.searchParams.append('topic', 'https://example.com/books/{id}');
  url.searchParams.append('topic', 'https://example.com/users/dunglas');
// The URL class is a convenient way to generate URLs such as https://localhost/.well-known/mercure?topic=https://example.com/books/{id}&topic=https://example.com/users/dunglas

  const eventSource = new EventSource(url);

// The callback will be called every time an update is published
  eventSource.onmessage = e => console.log(e); // do something with the payload
}
</script>