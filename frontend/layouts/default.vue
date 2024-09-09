<script setup lang="ts">
import {useUserStore} from "~/stores/user";
const store = useUserStore();
</script>

<template>
  <div>
    <p>Some default layout content shared across all pages</p>
    <p>Token: {{ store.getToken() }}</p>
    <p>Logged in: {{ store.isLoggedIn() }}</p>
    <p>Id: {{ store.id }}</p>
    <p>Email: {{ store.email }}</p>
    <ui-nav-link to="/" label="home" />
    <ui-nav-link v-if="!store.isLoggedIn()" to="/login" label="Увійти" />
    <ui-nav-link v-if="!store.isLoggedIn()" to="/register" label="Реєстрація" />
    <ui-nav-link v-if="store.isLoggedIn()" to="/ride/create" label="Створити поктушку" />
    <ui-nav-link to="/ride" label="Список покатушек" />
    <ui-link
      v-if="store.isLoggedIn()"
      to="/sign-in"
      label="Вийти"
      @click="store.logout()"
    />
    <slot />
  </div>
</template>

<style scoped>

</style>