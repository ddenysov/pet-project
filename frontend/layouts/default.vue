<script setup lang="ts">

</script>

<template>
  <div>
    <p>Some default layout content shared across all pages</p>
    <ui-nav-link to="/" label="home" />
    <ui-nav-link to="/sign-in" label="register" />
    <slot />
  </div>
</template>

<style scoped>

</style>