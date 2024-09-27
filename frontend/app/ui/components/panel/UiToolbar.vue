<script setup lang="ts">
</script>

<template>
  <Toolbar
    pt:root:class="border-none"
    pt:root:style="background-color: var(--p-primary-600)"
  >
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
