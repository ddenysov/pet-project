<script setup lang="ts">
import type {Responsive} from "~/app/ui/types/responsive";

export interface Props {
  value: string,
}
const props = defineProps<Props>();

const dateString = props.value;
const isoDateString = dateString.replace(' ', 'T');
const date = new Date(isoDateString);

const hours = date.getHours().toString().padStart(2, '0');
const minutes = date.getMinutes().toString().padStart(2, '0');

const timeString = `${hours}:${minutes}`;
</script>

<template>
  <span>{{ timeString }}</span>
</template>

<style scoped>

</style>