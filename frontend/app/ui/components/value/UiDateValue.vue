<script setup lang="ts">
import type {Responsive} from "~/app/ui/types/responsive";

export interface Props {
  value: string,
}
const props = defineProps<Props>();

const ukrMonths = {
  'Січня': 0,
  'Лютого': 1,
  'Березня': 2,
  'Квітня': 3,
  'Травня': 4,
  'Червня': 5,
  'Липня': 6,
  'Серпня': 7,
  'Вересня': 8,
  'Жовтня': 9,
  'Листопада': 10,
  'Грудня': 11
};

function formatUkrainianDate(dateString: any) {
  const date = new Date(dateString);

  const options = { day: 'numeric', month: 'long', year: 'numeric' };
  return date.toLocaleDateString('uk-UA', options);
}
</script>

<template>
  <span>{{ formatUkrainianDate(value) }}</span>
</template>

<style scoped>

</style>