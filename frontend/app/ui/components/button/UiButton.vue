<script setup lang="ts">
import type {ButtonProps} from "~/app/ui/types/button";

const props = defineProps<ButtonProps>()
</script>

<template>
  <Button :label="label" />
</template>

