<script setup lang="ts">
import { defineProps } from 'vue'
import { useFormStore } from './store/formStore';
import FieldError from "~/components/ui/form/Common/FieldError.vue";
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
</script>

<template>
  <ui-flex
    direction="column"
    :gap="2"
  >
    <label :for="name">{{ label }}</label>
    <Textarea
      v-model="store.values[form][name]"
      :disabled="store.isLoading(form) || disabled"
      rows="5"
      cols="30"
    />
    <field-error :form="form" :name="name" />
  </ui-flex>
</template>
