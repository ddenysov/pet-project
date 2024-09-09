<script setup lang="ts">
import UiGrid from '../../grid/UiGrid.vue'
import UiCol from '../../grid/UiCol.vue'
import {useDataStore} from "~/components/ui/data/store";

export interface Props {
  name: string,
}

const store = useDataStore();

console.log('alala');


defineProps<Props>()

const loading = ref(false)
loading.value = false
const totalRecords = ref(100)
const first = ref(0)
const data: Ref<any> = ref([
  {
    id: '123',
    name: 'alalal',
  }
])


console.log('store.rows');
console.log(store.rows);
if (!store.rows.ride) {
  store.load('rides', '/api/ride/list-ride');
}

</script>

<template>

  {{ store.isLoading('rides') }}

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
          <Card class="m-4" style="overflow: hidden">
            <template #header>
              alalal
            </template>
            <template #title><ui-nav-link :label="item.name" :to="'/ride/' + item.id" /></template>
            <template #subtitle>Card subtitle</template>
            <template #content>
              <p class="m-0">
                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Inventore sed consequuntur error repudiandae
                numquam deserunt quisquam repellat libero asperiores earum nam nobis, culpa ratione quam perferendis
                esse, cupiditate neque
                quas!
              </p>
            </template>
            <template #footer>
              <div class="flex gap-3 mt-1">
                <Button label="Cancel" severity="secondary" outlined class="w-full" />
                <Button label="Save" class="w-full" />
              </div>
            </template>
          </Card>
        </ui-col>
      </ui-grid>
    </template>
  </DataView>
</template>

<style scoped>

</style>