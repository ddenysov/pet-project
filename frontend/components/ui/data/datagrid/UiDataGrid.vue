<script setup lang="ts">
import UiGrid from '../../grid/UiGrid.vue'
import UiCol from '../../grid/UiCol.vue'
import {useDataStore} from "~/components/ui/data/store";

export interface Props {
  name: string,
  dataset: string,
}

const store = useDataStore();
const props = defineProps<Props>()

if (!store.rows.ride) {
  store.load(props.name, props.dataset);
}

</script>

<template>
  <DataView
    v-if="store.rows.rides"
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
</template>

<style scoped>

</style>