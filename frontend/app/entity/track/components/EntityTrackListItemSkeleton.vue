<script setup lang="ts">
export interface Props {
  rows: number,
}

defineProps<Props>();
</script>

<template>
  <div class="rounded border border-surface-200 dark:border-surface-700 bg-surface-0 dark:bg-surface-900">
    <ul class="m-0 p-0 list-none">
      <li v-for="index in rows" :key="index" class="mb-4">
        <ui-panel color="light" class="m-4 p-3">
          <div class="flex">
            <Skeleton size="4rem" class="mr-2"></Skeleton>
            <div class="self-center" style="flex: 1">
              <Skeleton width="100%" class="mb-2"></Skeleton>
              <Skeleton width="75%"></Skeleton>
            </div>
          </div>
        </ui-panel>
      </li>
    </ul>
  </div>
</template>

