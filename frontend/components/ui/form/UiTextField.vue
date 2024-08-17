<script setup lang="ts">
import { defineProps } from 'vue'
import { useFormStore } from './store/index';
const store = useFormStore();

export interface Props {
  original?: string,
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

</script>

<template>
  <ui-flex
    direction="column"
    :gap="2"
  >
    <label :for="name">{{ label }}</label>
    <InputText
      v-model="store.values[form][name]"
      :id="name"
      :disabled="store.isLoading(form)"
      aria-describedby="username-help"
    />
    <small id="username-help">{{ store.getFieldError(form, name) }}</small>
  </ui-flex>
</template>
