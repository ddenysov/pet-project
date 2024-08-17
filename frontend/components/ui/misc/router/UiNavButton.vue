<script setup lang="ts">
import { defineProps } from 'vue'
import type { NavButtonProps } from '@/shared/ui-kit/types/router'
import UiButton from '@/shared/ui-kit/ui/button/UiButton.vue'

defineProps<NavButtonProps>();

</script>

<template>
  <router-link :to="to">
      <ui-button
        :label="label"
        :color="color"
      />
  </router-link>
</template>
