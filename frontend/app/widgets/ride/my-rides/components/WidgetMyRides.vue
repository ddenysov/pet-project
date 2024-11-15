<template>
  <div class="card ui-ride-list">
    <ui-button label="Оновити" @click="() => store.load()" />
    <ui-dataset
      :layout-switcher="false"
      source="/api/ride/list-ride"
      name="ride"
      :page-size="5"
    >
      <template #skeleton="{ rows }">
        <entity-track-list-item-skeleton :rows="rows" />
      </template>
      <template #row="{ item }">
        <entity-track-list-item :track="item" />
      </template>
      <template #card="{ item }">
        <ui-card
          :title="item.name"
          subtitle="Довжина 95 км"
          class="m-3"
        >
          <template #header>
            <div class="m-3" style="height: 200px; background-color: var(--p-surface-300)" />
          </template>
        </ui-card>
      </template>
    </ui-dataset>
  </div>
</template>

<script setup>
import EntityTrackListItemSkeleton from "~/app/entity/track/components/EntityTrackListItemSkeleton.vue";
import EntityTrackListItem from "~/app/entity/track/components/EntityTrackListItem.vue";
import {useDatasetStore} from "~/app/ui/store/dataset";

const store = useDatasetStore('ride', '/api/ride/list-ride', 5)();

</script>
