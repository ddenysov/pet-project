<script setup lang="ts">

</script>

<template>
  <ui-grid>
    <ui-col v-for="(item) in [1, 2, 3, 4, 5, 6, 7, 8]" :key="item" :col="3">
      <div class="m-4">
        <Skeleton class="h-10rem" />
        <Skeleton class="mt-4 w-5 ml-2 h-2rem" />
        <Skeleton class="mt-4 w-10 ml-2" />
        <Skeleton class="mt-1 ml-2 " />
        <Skeleton class="mt-1 w-10 ml-2 " />
        <Skeleton class="mt-1 ml-2 " />
        <Skeleton class="mt-1 w-10 ml-2 " />
        <Skeleton class="mt-4 w-5 ml-2 h-2rem" />
      </div>
    </ui-col>
  </ui-grid>
</template>
