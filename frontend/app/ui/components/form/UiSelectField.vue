<script setup lang="ts">
import { defineProps } from 'vue'
import FieldError from "~/app/ui/components/form/Common/FieldError.vue";
import {useFormStore} from "~/app/ui/store/form";
import {useAsyncData} from "#app";
import {useApi} from "~/app/shared/api/composables/api";
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
    console.log(`Count changed from ${oldValue} to ${newValue}`);
    store.$patch({
      values: {
        [props.form]: {
          [props.name]: newValue,
        },
      },
    })
  }
);

const {data, status} = useAsyncData('track', async () => {
  const {get} = useApi();
  return await get('/api/track/list/my');
}, {lazy: true})

const cities = ref([
  { name: 'New York', code: 'NY' },
  { name: 'Rome', code: 'RM' },
  { name: 'London', code: 'LDN' },
  { name: 'Istanbul', code: 'IST' },
  { name: 'Paris', code: 'PRS' }
]);
</script>

<template>
  <ui-flex
    direction="column"
    :gap="2"
  >
    <label class="p-error" :for="name">{{ label }}</label>
    <Select
      v-model="store.values[form][name]"
      :options="data?.data"
      optionLabel="name"
      placeholder="Select a City"
      class="w-full md:w-56"
    />
    <field-error :form="form" :name="name" />
  </ui-flex>
</template>
