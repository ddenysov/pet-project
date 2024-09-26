<script setup lang="ts">
import {defineProps} from "vue";
import type {LinkProps} from "~/app/ui/types/link";

const props = defineProps<LinkProps>();
</script>

<template>
  <a href='#'>{{ props.label }}</a>
</template>

<style scoped>

</style>