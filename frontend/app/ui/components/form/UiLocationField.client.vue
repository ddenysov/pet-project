<script setup lang="ts">
import {defineProps} from 'vue'
import { useFormStore} from "~/app/ui/store/form";
import OsmMap from "~/app/ui/components/form/LocationField/OsmMap.vue";

const store = useFormStore();

export interface Props {
  original?: string,
  disabled?: boolean,
  name: string,
  label: string,
  form: string,
  validation?: {},
}
const props = defineProps<Props>();

store.$patch({
  values: {
    [props.form]: {
      [props.name]: props.original,
    },
  },
  validation: {
    [props.form]: {
      [props.name]: props.validation,
    },
  },
  errors: {
    [props.form]: {
      [props.name]: '',
    },
  },
  loading: {
    [props.form]: false,
  },
});

watch(
  () => props.original,
  (newValue, oldValue) => {
    store.$patch({
      values: {
        [props.form]: {
          [props.name]: newValue,
        },
      },
    })
  }
);


const onSelectLocation = (location) => {
  console.log('SELECT');
  console.log(location);
  store.$patch({
    values: {
      [props.form]: {
        [props.name]: location,
      },
    },
  })
}


const modalRef = ref(null);
const openModal = () => {
  modalRef.value.show();
};

</script>

<template>
  <ui-flex
    direction="column"
    :gap="2"
  >
    <label :for="name">{{ label }}</label>
    <ui-button :label="label" @click="openModal" />
    <ui-dialog style="width: 90%; height: 90%" ref="modalRef">
      <osm-map style="height: 90%" @select="onSelectLocation" />
    </ui-dialog>
    <small id="username-help">{{ store.getFieldError(form, name) }}</small>
  </ui-flex>
</template>
