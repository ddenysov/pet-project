<script setup lang="ts">
</script>

<template>
  <Toolbar style="border: none; border-radius: 0">
    <template #start>
      <slot name="start" />
    </template>
    <template #center>
      <slot name="center" />
    </template>
    <template #end>
      <slot name="end" />
    </template>
  </Toolbar>
</template>
