<template>
  <div>
    <feature-search-rides />
    <ui-section style="padding: 0 5rem; margin-bottom: 2rem">
      <widget-upcoming-rides />
    </ui-section>
    <ui-section style="padding: 0 5rem;">
      <widget-latest-tracks />
    </ui-section>
  </div>
</template>
<script setup lang="ts">
import UiSection from "~/app/ui/components/section/UiSection.vue";
import WidgetUpcomingRides from "~/app/widgets/ride/upcoming-rides/WidgetUpcomingRides.vue";
import WidgetLatestTracks from "~/app/widgets/track/latest-tracks/WidgetLatestTracks.vue";
import FeatureSearchRides from "~/app/features/ride/search-rides/FeatureSearchRides.vue";


definePageMeta({
  menu: 'main',
})
</script>

