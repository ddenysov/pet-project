<script setup lang="ts">
import { defineProps } from 'vue'
import type { NavButtonProps } from '@/shared/ui-kit/types/router'
import UiButton from '@/shared/ui-kit/ui/button/UiButton.vue'
import UiLink from '@/shared/ui-kit/ui/button/UiLink.vue'

defineProps<NavButtonProps>();
</script>

<template>
  <router-link :to="to">
      <ui-link
        :label="label"
      />
  </router-link>
</template>
