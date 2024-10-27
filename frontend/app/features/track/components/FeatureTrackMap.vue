<script setup lang="ts">

import UiMapTrackEditor from "~/app/ui/components/map/UiMapTrackEditor.vue";
import {useApi} from "~/app/shared/api/composables/api";

const api = useApi();

const saveTrack = async (selected: any) => {
  console.log(selected);
  await api.post('/api/track/create', {
    name: 'Track 123',
    path: selected,
  });
}
</script>

<template>
  <div class="nested">
    <div>Create track</div>
    <ui-map-track-editor @save="saveTrack" />
  </div>
</template>

<style scoped>

</style>