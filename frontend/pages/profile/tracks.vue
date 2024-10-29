<script setup lang="ts">

import WidgetProfile from "~/app/widgets/profile/components/WidgetProfile.vue";
import WidgetMyTracks from "~/app/widgets/track/my-tracks/components/WidgetMyTracks.vue";
import FeatureUploadTrackGpx from "~/app/features/track/components/FeatureUploadTrackGpx.vue";

</script>

<template>
  <widget-profile active="tracks">
    <template #title>
      Маршрути
    </template>
    <template #content>
      <div>
        Маршрути в розробці
        <ui-button
          class="ml-2"
          label="Додати маршрут"
          @click="() => navigateTo('/track/create')"
        />
        <feature-upload-track-gpx />
        <widget-my-tracks/>
      </div>
    </template>
  </widget-profile>
</template>

<style scoped>

</style>