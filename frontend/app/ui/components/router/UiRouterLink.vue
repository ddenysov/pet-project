<script setup lang="ts">
import { defineProps } from 'vue'
import type {RouterProps} from "~/app/ui/types/route";

const props = defineProps<RouterProps>();
</script>

<template>
  <NuxtLink class="ui-link" :to="to" >
    {{ props.label }}
  </NuxtLink>
</template>
