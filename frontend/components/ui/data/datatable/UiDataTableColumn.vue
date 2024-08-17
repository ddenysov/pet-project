<script lang="ts">
import { defineComponent, defineProps } from 'vue'
export interface Props {
  name: string,
  label?: string,
  sortable?: boolean,
}

const props = defineProps<Props>();

export default defineComponent({
  name: 'UiDataTableColumn'
})
</script>

<template>
  <div>ololo trololo</div>
</template>

<style scoped>

</style>