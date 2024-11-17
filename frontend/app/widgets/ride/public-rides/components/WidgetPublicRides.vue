<template>
  <div class="card ui-ride-list">
    <ui-dataset
      :border="false"
      :layout-switcher="false"
      source="/api/ride/list-ride"
      name="publicRide"
      layout="grid"
      :page-size="8"
      default-order-by="start_date_time"
      default-order-dir="desc"
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
