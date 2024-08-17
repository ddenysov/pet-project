<script setup lang="ts">

</script>

<template>
  <div>
    <p>Some default layout content shared across all pages</p>
    <ui-nav-link to="/" label="home" />
    <ui-nav-link to="/register" label="register" />
    <ui-nav-link to="/login" label="login" />
    <slot />
  </div>
</template>

<style scoped>

</style>