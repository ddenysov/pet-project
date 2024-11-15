<template>
  <div class="card ui-ride-list">
    <ui-dataset
      :border="false"
      :layout-switcher="false"
      source="/api/ride/list-ride"
      name="publicRide"
      layout="grid"
    >
      <template #card="{ item }">
        <entity-ride-card :ride="item" />
      </template>
    </ui-dataset>
  </div>
</template>

<script setup>
import EntityRideCard from "~/app/entity/ride/components/EntityRideCard.vue";

</script>
