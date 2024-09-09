<template>
  <div>
    <h1>Деталі покатушки</h1>

    <div>
    <ui-flex>
      <ui-flex grow="1" direction="column">
        Деталі {{ route.params.id }}
      </ui-flex>
    </ui-flex>
    </div>
  </div>
</template>
<script setup lang="ts">
const route = useRoute()

// When accessing /posts/1, route.params.id will be 1
console.log(route.params.id)
</script>
