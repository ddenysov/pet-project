<script setup lang="ts">
import { defineProps } from 'vue'
import type {RouterProps} from "~/app/ui/types/route";

const props = defineProps<RouterProps>();
</script>

<template>
  <NuxtLink :to="to" >
    {{ props.label }}
  </NuxtLink>
</template>
