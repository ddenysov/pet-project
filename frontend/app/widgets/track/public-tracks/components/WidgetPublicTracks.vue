<template>
  <div class="card ui-ride-list">
    <ui-grid>
      <ui-col :col="4">
        <ui-dataset
          source="/api/track/list"
          :page-size="5"
          layout="list"
          name="track"
        >
          <template #skeleton="{ rows }">
            <entity-track-list-item-skeleton  :rows="rows" />
          </template>
          <template #row="{ item }">
            <entity-track-list-item @select="onSelectTrack" :selected="selected" :track="item" />
          </template>
        </ui-dataset>
      </ui-col>
      <ui-col :col="8">
        <ui-map-track-viewer :path="path" />
      </ui-col>
    </ui-grid>

  </div>
</template>

<script setup>
import EntityTrackListItemSkeleton from "~/app/entity/track/components/EntityTrackListItemSkeleton.vue";
import EntityTrackListItem from "~/app/entity/track/components/EntityTrackListItem.vue";

const path = ref([]);
const selected = ref({});

const onSelectTrack = (track) => {
  selected.value = track;
  path.value = JSON.parse(track.path);
}
</script>
