<script setup lang="ts">
import { useFormStore} from "~/app/ui/store/form";

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
    const res = await store.submit(props.form, props.action);
    emit('submit', { res, values: store.getValues(props.form)});
  } catch (e: any) {
    emit('error', e.data);
  }
}
</script>

<template>
  <ui-button
    @click="onClick"
    :label="label"
  />
</template>
