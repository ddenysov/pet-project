<template>
  <div class="card ui-ride-list">
    <ui-dataset />
  </div>
</template>

<script setup>
import {onMounted, ref} from "vue";
import {useApi} from "~/app/shared/api/composables/api";
import {useDatasetStore} from "~/app/ui/store/dataset.ts";
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