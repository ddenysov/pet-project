<template>
  <div class="card ui-ride-list">
    <ui-dataset>
      <template #skeleton="{ rows }">
        <entity-track-list-item-skeleton :rows="rows" />
      </template>
      <template #row="{ item }">
        <entity-track-list-item :track="item" />
      </template>
    </ui-dataset>
  </div>
</template>

<script setup>
import EntityTrackListItemSkeleton from "~/app/entity/track/components/EntityTrackListItemSkeleton.vue";
import EntityTrackListItem from "~/app/entity/track/components/EntityTrackListItem.vue";
</script>
