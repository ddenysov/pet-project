<template>
  <div>
    {{ status }}
    {{ loading }}
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
          <div v-if="loading" class="rounded border border-surface-200 dark:border-surface-700 p-6 bg-surface-0 dark:bg-surface-900">
            <ul class="m-0 p-0 list-none">
              <li v-for="index in 5" :key="index" class="mb-4">
                <div class="flex">
                  <Skeleton size="4rem" class="mr-2"></Skeleton>
                  <div class="self-center" style="flex: 1">
                    <Skeleton width="100%" class="mb-2"></Skeleton>
                    <Skeleton width="75%"></Skeleton>
                  </div>
                </div>
              </li>
            </ul>
          </div>
        </template>
        <template #list="slotProps">
          <div v-if="!loading">
            <ui-panel color="dark" class="my-2">
              <div v-for="(item, index) in slotProps.items" :key="index">
                <ui-panel color="light" class="m-4 p-3">
                  <ui-flex justify-content="between">
                    <ui-flex>
                      <div class="ui-ride-image" />
                    </ui-flex>
                    <ui-flex :gap="2" :grow="1" direction="column" class="px-2">
                      <ui-flex>
                        {{ item.name }}
                      </ui-flex>
                      <ui-flex>
                        Довжина: 95 км
                      </ui-flex>
                    </ui-flex>
                    <ui-flex align-items="center">
                      <Button text style="height: 40px" type="button" icon="pi pi-ellipsis-v"
                              @click="(e) => toggle(index, e)"
                              aria-haspopup="true" aria-controls="overlay_menu" />
                      <Menu :key="index" :ref="el => setItemRef(el, index)" id="overlay_menu" :model="menuItems"
                            :popup="true" />
                    </ui-flex>
                  </ui-flex>
                </ui-panel>
              </div>
            </ui-panel>
          </div>
          <div v-else>
            <div class="rounded border border-surface-200 dark:border-surface-700 p-6 bg-surface-0 dark:bg-surface-900">
              <ul class="m-0 p-0 list-none">
                <li v-for="index in 5" :key="index" class="mb-4">
                  <div class="flex">
                    <Skeleton size="4rem" class="mr-2"></Skeleton>
                    <div class="self-center" style="flex: 1">
                      <Skeleton width="100%" class="mb-2"></Skeleton>
                      <Skeleton width="75%"></Skeleton>
                    </div>
                  </div>
                </li>
              </ul>
            </div>
          </div>
        </template>

        <template #grid="slotProps">
          <div>
            Grid
          </div>
        </template>
      </DataView>
    </div>
  </div>
</template>

<script setup>
import {ref} from "vue";
import {useAsyncData} from "#app";

const itemRefs = ref([]);
const page = ref(0);

const setItemRef = (el, index) => {
  if (el) {
    itemRefs.value[index] = el;
  }
};
const menuItems = ref([
  {
    items: [
      {
        label: 'Деталі',
        icon: 'pi pi-refresh'
      },
      {
        label: 'Скасувати',
        icon: 'pi pi-upload'
      },
      {
        label: 'Редагувати',
        icon: 'pi pi-refresh'
      },
    ]
  }
]);

const toggle = (index, event) => {
  itemRefs.value[index].toggle(event);
};

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


<style scoped>
.ui-ride-image {
  background-color: var(--p-surface-300);
  width: 70px;
  height: 50px;
}

.ui-ride-list {
  .p-dataview-header {
    border-style: none !important;
  }
}
</style>