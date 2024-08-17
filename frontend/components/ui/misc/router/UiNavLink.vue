<script setup lang="ts">
import { defineProps } from 'vue'
import type { NavButtonProps } from '../../../types/router'
import UiLink from '../../button/UiLink.vue'

defineProps<NavButtonProps>();
</script>

<template>
  <NuxtLink :to="to" >
    <ui-link
      :label="label"
    />
  </NuxtLink>
</template>
