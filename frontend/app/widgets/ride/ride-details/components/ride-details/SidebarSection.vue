<script setup lang="ts">

</script>

<template>
  <ui-flex direction="column" class="bg-white">
    <ui-flex gap="2" class="p-3">
      <ui-flex>
        <slot name="right" />
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