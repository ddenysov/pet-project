<script setup lang="ts">
import { defineProps, defineEmits } from 'vue'
import { useFormStore } from './store/index';
const store = useFormStore();

export interface Props {
  label: string,
  form: string,
  action: string,
}

const props = defineProps<Props>();
const emit = defineEmits(['error', 'submit', 'click'])

const onClick = async () => {
  try {
    console.log('ok');
    await store.submit(props.form, props.action);
    emit('submit', store.getValues(props.form));
  } catch (e) {
    emit('error', e.data);
  }
}
</script>

<template>
  <ui-button
    :disabled="store.isLoading(props.form)"
    @click="onClick"
    :label="label"
  />
</template>
