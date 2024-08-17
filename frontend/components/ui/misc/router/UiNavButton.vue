<script setup lang="ts">
import { defineProps } from 'vue'
import type { NavButtonProps } from '../../../types/router'
import UiButton from '../../button/UiButton.vue'

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
