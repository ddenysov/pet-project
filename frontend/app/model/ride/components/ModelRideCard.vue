<script setup lang="ts">
import type {Ride} from "~/app/model/ride/types/ride";

export interface Props {
  ride: Ride,
}

defineProps<Props>();
</script>

<template>
  <ui-card style="margin: 10px">
    <template #header>
      <div class="image-container">
        <img :src="ride.preview_image_url"  :alt="ride.name" />
      </div>
    </template>
    <template #title>
      <ui-router-link :label="ride.name" :to="'/ride/view/' + ride.id" />
    </template>
    <template #footer>
      <div class="flex gap-3 mt-1">
        <slot name="actions" />
      </div>
    </template>
  </ui-card>
</template>

<style scoped>

</style>