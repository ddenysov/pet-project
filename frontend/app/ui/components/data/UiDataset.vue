<template>
  <div>
    <DataView
      paginator
      @page="onPageClick"
      :total-records="20"
      :lazy="true"
      :rows="pageSize"
      :value="store.data"
      :layout="layout"
      :pt="{
        header: { style: 'background: none' },
        content: { style: 'background: none' },
    }"
    >
      <template v-if="true" #header>
        <div class="flex justify-end">
          <SelectButton v-if="layoutSwitcher" v-model="layout" :options="options" :allowEmpty="false">
            <template #option="{ option }">
              <i :class="[option === 'list' ? 'pi pi-bars' : 'pi pi-table']" />
            </template>
          </SelectButton>
        </div>
      </template>
      <template #empty>
        <div v-if="store.loading">
          <slot :rows="skeletonRowsCount" name="skeleton" />
        </div>
      </template>
      <template #list="slotProps">
        <slot name="main">
          <ui-panel color="dark" class="my-2">
            <div v-if="!store.loading">
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
            <ui-col v-for="(item, index) in slotProps.items" :key="index" :col="3">
              <slot :key="index" :item="item" name="card" />
            </ui-col>
          </ui-grid>
        </ui-panel>
      </template>
    </DataView>
  </div>
</template>

<script setup lang="ts">
import {defineProps, onMounted, ref} from "vue";
import {useAsyncData} from "#app";
import UiCol from "~/app/ui/components/grid/UiCol.vue";
import {useDatasetStore} from "~/app/ui/store/dataset";

interface Props {
  pageSize?: number,
  source: string,
  layout?: string,
  layoutSwitcher?: boolean,
  name: string,
}

const props = withDefaults(defineProps<Props>(), {
  layout: 'list',
  layoutSwitcher: false,
  pageSize: 12,
})

const layout = ref('list');
const options = ref(['list', 'grid']);
const skeletonRowsCount = ref(10);
layout.value = props.layout;

const store = useDatasetStore(props.name, props.source)();

await useAsyncData(props.name, async () => {
  console.log('load ' + props.name)
  await store.init();

  return store.data;
}, { lazy: true })


const onPageClick = (e: any) => {
  store.setPage(e.page)
}


</script>
