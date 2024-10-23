<template>
  <widget-profile active="rides">
    <template #title>
      Покатушки
    </template>
    <template #content>
      <div>
        <h1>Створити покатушку</h1>
        <feature-ride-form />
      </div>
    </template>
  </widget-profile>
</template>
<script setup lang="ts">
import FeatureRideForm from "~/app/features/ride/components/FeatureRideForm.vue";
import WidgetProfile from "~/app/widgets/profile/components/WidgetProfile.vue";

definePageMeta({
  menu: 'ride',
})
</script>
