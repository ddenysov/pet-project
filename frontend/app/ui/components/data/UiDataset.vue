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
        <div v-if="loading">
          <slot :rows="skeletonRowsCount" name="skeleton" />
        </div>
      </template>
      <template #list="slotProps">
        <slot name="main">
          <ui-panel color="dark" class="my-2">
            <div v-if="!loading">
              <div v-for="(item, index) in slotProps.items" :key="index">
                <slot :item="item" name="row" />
              </div>
            </div>
            <div v-else>
              <slot :rows="skeletonRowsCount" name="skeleton" />
            </div>
          </ui-panel>
        </slot>
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

const page = ref(0);
const layout = ref('list');

const {data, status} = useAsyncData('track', async () => {
  return await $fetch('/api/track/list?page=' + page.value);
}, {
  watch: [page]
})

const skeletonRowsCount = computed(() => {
  if (data.value.data.length > 0) {
    return data.value?.data.length;
  }

  return data.value?.page.size;
});

const pageClick = (e) => {
  page.value = e.page;
}

const loading = computed(() => status.value === 'pending');

</script>
