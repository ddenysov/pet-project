<script setup lang="ts">
import {defineProps} from "vue";

export interface Props {
  home: object,
  items: [],
}

const props = defineProps<Props>();
</script>

<template>
  <Breadcrumb :home="home" :model="items">
    <template #item="{ item, props }">
      <router-link v-if="item.route" v-slot="{ href, navigate }" :to="item.route" custom>
        <a :href="href" v-bind="props.action" @click="navigate">
          <span  :class="[item.icon, 'text-color']" />
          <span class="ui-link font-semibold">{{ item.label }}</span>
        </a>
      </router-link>
      <a v-else :href="item.url" :target="item.target" v-bind="props.action">
        <span class="text-surface-700 dark:text-surface-0">{{ item.label }}</span>
      </a>
    </template>
  </Breadcrumb>
</template>

<style scoped>

</style>