<script setup lang="ts">
import {defineProps, ref} from "vue";

export interface Props {
  track: {},
  selected?: {},
}

const props =defineProps<Props>();

/**
 * State
 */
const itemRefs = ref([]);

/**
 * Actions
 */
const toggle = (index: any, event: any) => {
  itemRefs.value[index].toggle(event);
};
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

const $emit = defineEmits(['select']);

const color = computed(() => props.track.id === props.selected?.id ? 'var(--p-amber-100)' : 'white');

</script>

<template>
  <ui-panel :style="'cursor: pointer; background-color: ' + color + ' '" color="light" class="widget-track-list-item m-4 p-3" @click="() => $emit('select', track)">
    <ui-flex justify-content="between">
      <ui-flex>
        <div class="ui-ride-image" />
      </ui-flex>
      <ui-flex :gap="2" :grow="1" direction="column" class="px-2">
        <ui-flex>
          <ui-router-link :label="track.name" :to="'/track/details/' + track.id" />
        </ui-flex>
        <ui-flex>
          Довжина: {{ track.length }} км
        </ui-flex>
      </ui-flex>
      <ui-flex align-items="center">
        <Button
          text
          style="height: 40px"
          type="button"
          icon="pi pi-ellipsis-v"
          @click="(e) => toggle(track.id, e)"
          aria-haspopup="true"
          aria-controls="overlay_menu"
        />
        <Menu
          :ref="el => setItemRef(el, track.id)"
          id="overlay_menu"
          :model="menuItems"
          :popup="true"
        />
      </ui-flex>
    </ui-flex>
  </ui-panel>
</template>

<style scoped>
.ui-ride-image {
  background-color: var(--p-surface-300);
  width: 70px;
  height: 50px;
}

.widget-track-list-item:hover {
  background-color: var(--p-amber-100) !important; /* Задайте нужный цвет фона */
}
</style>