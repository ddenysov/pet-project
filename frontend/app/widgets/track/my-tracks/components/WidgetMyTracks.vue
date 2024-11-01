<template>
  <div class="card ui-ride-list">
    {{ status }}
    <DataView v-if="data" paginator :rows="5" :value="data.data" :layout="layout">
      <template #list="slotProps">
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
                  <Button text style="height: 40px" type="button" icon="pi pi-ellipsis-v" @click="(e) => toggle(index, e)" aria-haspopup="true" aria-controls="overlay_menu" />
                  <Menu :key="index" :ref="el => setItemRef(el, index)" id="overlay_menu" :model="items" :popup="true" />
                </ui-flex>
              </ui-flex>
            </ui-panel>
          </div>
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
import {onMounted, ref} from "vue";
import {useApi} from "~/app/shared/api/composables/api";
const itemRefs = ref([]);

const setItemRef = (el, index) => {
  if (el) {
    itemRefs.value[index] = el;
  }
};
const items = ref([
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

const api = useApi();

const myTracks = ref([]);
const { data, status } = api.getAsync('/api/track/list');
console.log('res.data');
console.log(data);
myTracks.value = data.data;


console.log('myTracks.value');
console.log(myTracks);

const products = ref([
  {
    id: '1000',
    code: 'f230fh0g3',
    name: 'Bamboo Watch',
    description: 'Product Description',
    image: 'bamboo-watch.jpg',
    price: 65,
    category: 'Accessories',
    quantity: 24,
    inventoryStatus: 'INSTOCK',
    rating: 5
  },
  {
    id: '1000',
    code: 'f230fh0g3',
    name: 'Bamboo Watch',
    description: 'Product Description',
    image: 'bamboo-watch.jpg',
    price: 65,
    category: 'Accessories',
    quantity: 24,
    inventoryStatus: 'INSTOCK',
    rating: 5
  },
  {
    id: '1000',
    code: 'f230fh0g3',
    name: 'Bamboo Watch',
    description: 'Product Description',
    image: 'bamboo-watch.jpg',
    price: 65,
    category: 'Accessories',
    quantity: 24,
    inventoryStatus: 'INSTOCK',
    rating: 5
  },
  {
    id: '1000',
    code: 'f230fh0g3',
    name: 'Bamboo Watch',
    description: 'Product Description',
    image: 'bamboo-watch.jpg',
    price: 65,
    category: 'Accessories',
    quantity: 24,
    inventoryStatus: 'INSTOCK',
    rating: 5
  },
  {
    id: '1000',
    code: 'f230fh0g3',
    name: 'Bamboo Watch',
    description: 'Product Description',
    image: 'bamboo-watch.jpg',
    price: 65,
    category: 'Accessories',
    quantity: 24,
    inventoryStatus: 'INSTOCK',
    rating: 5
  },
  {
    id: '1000',
    code: 'f230fh0g3',
    name: 'Bamboo Watch',
    description: 'Product Description',
    image: 'bamboo-watch.jpg',
    price: 65,
    category: 'Accessories',
    quantity: 24,
    inventoryStatus: 'INSTOCK',
    rating: 5
  },
  {
    id: '1000',
    code: 'f230fh0g3',
    name: 'Bamboo Watch',
    description: 'Product Description',
    image: 'bamboo-watch.jpg',
    price: 65,
    category: 'Accessories',
    quantity: 24,
    inventoryStatus: 'INSTOCK',
    rating: 5
  },
  {
    id: '1000',
    code: 'f230fh0g3',
    name: 'Bamboo Watch',
    description: 'Product Description',
    image: 'bamboo-watch.jpg',
    price: 65,
    category: 'Accessories',
    quantity: 24,
    inventoryStatus: 'INSTOCK',
    rating: 5
  },

]);
const layout = ref('list');
const options = ref(['list', 'grid']);

const getSeverity = (product) => {
  switch (product.inventoryStatus) {
    case 'INSTOCK':
      return 'success';

    case 'LOWSTOCK':
      return 'warn';

    case 'OUTOFSTOCK':
      return 'danger';

    default:
      return null;
  }
}

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