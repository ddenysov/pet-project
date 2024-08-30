<script setup lang="ts">
import {useUserStore} from "~/stores/user";
const store = useUserStore();
const session = useCookie<{ name: string }>('session')

const isLoggedIn = () => {
  return store.token;
}

const logOut = () => {
  store.logout();
  session.value = { name: '' };
}
</script>

<template>
  <div>
    <p>Some default layout content shared across all pages</p>
    <ui-nav-link to="/" label="home" />
    <ui-nav-link to="/sign-in" label="register" />
    <ui-nav-link to="/ride/create" label="Create Ride" />
    <ui-link
      v-if="isLoggedIn()"
      to="/sign-in"
      label="log out"
      @click="logOut()"
    />
    <slot />
  </div>
</template>

<style scoped>

</style>