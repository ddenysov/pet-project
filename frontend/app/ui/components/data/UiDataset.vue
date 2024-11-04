<template>
  <div>
    <DataView
      @page="pageClick"
      paginator
      :total-records="data?.records.filtered"
      :lazy="true"
      :rows="data?.page.size"
      :value="data?.data"
      :layout="layout"
    >
      <template #empty>
        <entity-track-list-item-skeleton :rows="5" v-if="loading" />
      </template>
      <template #list="slotProps">
        <ui-panel color="dark" class="my-2">
          <div v-if="!loading">
            <div v-for="(item, index) in slotProps.items" :key="index">
              <entity-track-list-item :track="item" />
            </div>
          </div>
          <entity-track-list-item-skeleton v-else :rows="data?.data.length" />
        </ui-panel>
      </template>

      <template #grid="slotProps">
        <div>
          Grid
        </div>
      </template>
    </DataView>
  </div>
</template>

<script setup>
import {ref} from "vue";
import {useAsyncData} from "#app";
import EntityTrackListItem from "~/app/entity/track/components/EntityTrackListItem.vue";
import EntityTrackListItemSkeleton from "~/app/entity/track/components/EntityTrackListItemSkeleton.vue";

const page = ref(0);
const layout = ref('list');

const {data, status} = useAsyncData('track', async () => {
  return await $fetch('/api/track/list?page=' + page.value);
}, {
  watch: [page]
})


const pageClick = (e) => {
  page.value = e.page;
}

const loading = computed(() => status.value === 'pending');

</script>
