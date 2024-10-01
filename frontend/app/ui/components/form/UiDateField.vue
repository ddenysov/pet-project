<script setup lang="ts">
import { defineProps } from 'vue'
import { useFormStore} from "~/app/ui/store/form";

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
</script>

<template>
  <ui-flex
    direction="column"
    :gap="2"
  >
    <label :for="name">{{ label }}</label>
    <DatePicker
      v-model="store.values[form][name]"
      :disabled="store.isLoading(form) || disabled"
    />
    <small id="username-help">{{ store.getFieldError(form, name) }}</small>
  </ui-flex>
</template>
