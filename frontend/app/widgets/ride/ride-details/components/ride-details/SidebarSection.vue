<script setup lang="ts">

</script>

<template>
  <ui-flex style="background-color: var(--p-surface-100);" direction="column">
    <ui-flex gap="2" class="p-3">
      <ui-flex align-items="center">
        <font-awesome style="font-size: 30px; color: var(--p-primary-color); margin-right: 10px" :icon="['fas', 'calendar-days']" />
      </ui-flex>
      <ui-flex justify-content="between" direction="column" :grow="1">
        <ui-flex class="p-1"><slot name="first" /></ui-flex>
        <ui-flex class="p-1"><slot name="second" /></ui-flex>
      </ui-flex>
    </ui-flex>
    <div class="bg-gray-600">
      <slot name="bottom" />
    </div>
  </ui-flex>
</template>

<style scoped>

</style>