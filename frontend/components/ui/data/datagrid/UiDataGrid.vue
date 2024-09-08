<script setup lang="ts">
import {onMounted, type Ref, ref } from 'vue'
import UiGrid from '../../grid/UiGrid.vue'
import UiCol from '../../grid/UiCol.vue'
import {useDataStore} from "~/components/ui/data/store";

export interface Props {
  name: string,
}

const store = useDataStore();

console.log('alala');
store.load('rides', '/api/ride/list-ride');

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


onMounted(async () => {
  //await loadData()
});

const onPage = async (event: any) => {
  //await loadData();
}

</script>

<template>

  <div>{{ store.loading }}</div>

  <ui-grid v-if="!!store.loading.rides">
    <ui-col v-for="(item, index) in [1, 2, 3, 4, 5, 6, 7, 8]" :key="index" :col="3">
      <div class="m-4">
        <Skeleton class="h-10rem" />

        <Skeleton class="mt-4 w-5 ml-2 h-2rem" />

        <Skeleton class="mt-4 w-10 ml-2" />
        <Skeleton class="mt-1 ml-2 " />
        <Skeleton class="mt-1 w-10 ml-2 " />
        <Skeleton class="mt-1 ml-2 " />
        <Skeleton class="mt-1 w-10 ml-2 " />

        <Skeleton class="mt-4 w-5 ml-2 h-2rem" />
      </div>

    </ui-col>
  </ui-grid>
  <DataView
    v-else
    :value="store.rows.rides"
    paginator
    :rows="8"
    :total-records="10000"
    lazy
    @page="onPage"
  >
    <template #list="slotProps">
      <ui-grid>
        <ui-col v-for="(item, index) in slotProps.items" :key="index" :col="3">
          <Card class="m-4" style="overflow: hidden">
            <template #header>
              alalal
            </template>
            <template #title>{{ item.name }}</template>
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