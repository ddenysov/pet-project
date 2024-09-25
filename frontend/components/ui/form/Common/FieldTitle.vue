<script setup lang="ts">
import {defineProps} from "vue";
import {useFormStore} from "~/components/ui/form/store/formStore";

export interface Props {
  name: string,
  form: string,
}
const props = defineProps<Props>();
const store = useFormStore();
</script>

<template>
  <small class="text-red-200">{{ store.getFieldError(form, name) }}</small>
</template>

<style scoped>

</style>