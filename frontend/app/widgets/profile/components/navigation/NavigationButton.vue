<script setup lang="ts">
import {defineProps} from "vue";

export interface Props {
  icon: string,
  label: string,
  to: string,
  active?: boolean,
}

const props = withDefaults(defineProps<Props>(), {
  active: false,
})

</script>

<template>
  <Button
    :icon="'pi pi-' + icon"
    style="justify-content: flex-start"
    class="w-full"
    :label="label"
    :severity="active ? 'primary' : 'secondary'"
    @click="() => navigateTo(to)"
  />
</template>

<style scoped>

</style>