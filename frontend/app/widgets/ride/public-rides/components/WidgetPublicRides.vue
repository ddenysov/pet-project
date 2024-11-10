<template>
  <div class="card ui-public-ride-list">
    <ui-dataset source="/api/ride/list-ride" name="ride">
      <template #card="{ item }">
        <entity-ride-card :ride="item" />
      </template>
    </ui-dataset>
  </div>
</template>

<script setup>
import EntityTrackListItemSkeleton from "~/app/entity/track/components/EntityTrackListItemSkeleton.vue";
import EntityTrackListItem from "~/app/entity/track/components/EntityTrackListItem.vue";
import EntityRideCard from "~/app/entity/ride/components/EntityRideCard.vue";
</script>
