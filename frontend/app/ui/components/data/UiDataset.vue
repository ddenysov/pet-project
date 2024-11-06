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
      <template #header>
        <div class="flex justify-end">
          <SelectButton v-model="layout" :options="options" :allowEmpty="false">
            <template #option="{ option }">
              <i :class="[option === 'list' ? 'pi pi-bars' : 'pi pi-table']" />
            </template>
          </SelectButton>
        </div>
      </template>
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
        <ui-panel color="dark" class="my-2">
          <ui-grid>
            <ui-col v-for="(item, index) in slotProps.items" :key="index" :col="4">
              <slot :key="index" :item="item" name="card" />
            </ui-col>
          </ui-grid>
        </ui-panel>
      </template>
    </DataView>
  </div>
</template>

<script setup lang="ts">
import {ref} from "vue";
import {useAsyncData} from "#app";
import UiCol from "~/app/ui/components/grid/UiCol.vue";

interface Props {
  source: string,
}

const props = defineProps<Props>();

const page = ref(0);
const layout = ref('list');
const options = ref(['list', 'grid']);

const {data, status} = useAsyncData('track', async () => {
  return await $fetch(props.source + '?page=' + page.value);
}, {
  watch: [page]
}, {lazy: true})

const skeletonRowsCount = computed(() => {
  if (data.value?.data.length > 0) {
    return data.value?.data.length;
  }

  return data.value?.page.size ?? 1;
});

const pageClick = (e) => {
  page.value = e.page;
}

const loading = computed(() => status.value === 'pending');



</script>
