<script setup lang="ts">
import { defineProps, defineEmits } from 'vue'
import { useFormStore } from './store/index';
import UiButton from '@/shared/ui-kit/ui/button/UiButton.vue'
const store = useFormStore();

export interface Props {
  label: string,
  form: string,
}

const props = defineProps<Props>();
const emit = defineEmits(['error', 'submit', 'click'])

const onClick = async () => {
  try {
    console.log('ok');
    await store.submit(props.form);
    emit('submit', store.getValues(props.form));
  } catch (e) {
    emit('error', e);
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
