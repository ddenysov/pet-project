<template>
  <div>
    <DataView
      paginator
      @page="onPageClick"
      :total-records="store.total"
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
          <component :is="wrapperComponent" color="dark">
            <div v-if="!store.loading">
              <div v-for="(item, index) in slotProps.items" :key="index">
                <slot :item="item" name="row" />
              </div>
            </div>
            <div v-else>
              <slot :rows="skeletonRowsCount" name="skeleton" />
            </div>
          </component>
        </slot>
      </template>

      <template #grid="slotProps">
        <component :is="wrapperComponent" color="dark">
          <div v-if="!store.loading">
            <ui-grid>
              <ui-col v-for="(item, index) in slotProps.items" :key="index" :col="3">
                <slot :key="index" :item="item" name="card" />
              </ui-col>
            </ui-grid>
          </div>
          <div v-else>
            <slot :rows="pageSize" name="skeletonCard">
              <ui-grid>
                <ui-col v-for="(item) in [1, 2, 3, 4, 5, 6, 7, 8]" :key="item" :col="3">
                  <div class="m-4">
                    <Skeleton class="h-10rem" />
                    <Skeleton class="mt-4 w-5 ml-2 h-2rem" />
                    <Skeleton class="mt-4 w-10 ml-2" />
                  </div>
                </ui-col>
              </ui-grid>
            </slot>
          </div>
        </component>
      </template>
    </DataView>
  </div>
</template>

<script setup lang="ts">
import {defineProps, onMounted, ref} from "vue";
import {useAsyncData} from "#app";
import UiCol from "~/app/ui/components/grid/UiCol.vue";
import {useDatasetStore} from "~/app/ui/store/dataset";
import UiPanel from "~/app/ui/components/panel/UiPanel.vue";

interface Props {
  pageSize?: number,
  source: string,
  layout?: string,
  layoutSwitcher?: boolean,
  name: string,
  border?: boolean,
  defaultOrderBy: string,
  defaultOrderDir: string,
}

const props = withDefaults(defineProps<Props>(), {
  layout: 'list',
  layoutSwitcher: false,
  pageSize: 12,
  border: true,
})

const layout = ref('list');
const options = ref(['list', 'grid']);
const skeletonRowsCount = ref(10);
layout.value = props.layout;

const store = useDatasetStore(props.name, props.source)();

await useAsyncData(props.name, async () => {
  await store.init({
    pageSize: props.pageSize,
    defaultSortOrderBy: props.defaultOrderBy,
    defaultSortOrderDir: props.defaultOrderDir,
  });

  return store.data;
}, {lazy: true})


const onPageClick = (e: any) => {
  store.setPage(e.page)
}

const wrapperComponent = computed(() => props.border ? UiPanel : 'div');

</script>
