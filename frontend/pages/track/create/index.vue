<template>
  <div class="nested m-3">
    <h1>Створити трек</h1>
    <feature-track-map />
  </div>
</template>
<script setup lang="ts">
import {useMessageStore} from "~/app/ui/store/messages";
import FeatureRideForm from "~/app/features/ride/components/FeatureRideForm.vue";
import FeatureTrackMap from "~/app/features/track/components/FeatureTrackMap.vue";

definePageMeta({
  layout: 'full-width',
  menu: 'main',
})

</script>
