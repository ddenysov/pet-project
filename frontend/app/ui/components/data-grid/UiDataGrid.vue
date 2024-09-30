<script setup lang="ts">
import UiGrid from "~/app/ui/components/grid/UiGrid.vue";
import UiCol from "~/app/ui/components/grid/UiCol.vue";
import {useDataStore} from "~/app/ui/store/data";

export interface Props {
  name: string,
  dataset: string,
}

const store = useDataStore();
const props = defineProps<Props>()

store.init(props.name, props.dataset);



</script>

<template>
  {{ store.isLoading(name) }}
  <DataView
    v-if="!store.isLoading(name)"
    :value="store.rows.rides"
    paginator
    :rows="8"
    :total-records="10000"
    lazy
  >
    <template #list="slotProps">
      <ui-grid>



        <ui-col v-for="(item, index) in slotProps.items" :key="index" :col="3">
          <slot :item="item" />
        </ui-col>
      </ui-grid>
    </template>
  </DataView>
  <ui-data-grid-loader v-else />
</template>

<style scoped>

</style>