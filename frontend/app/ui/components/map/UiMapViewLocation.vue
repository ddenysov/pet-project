<script setup lang="ts">
import {defineProps} from "vue";
import type {Location} from "~/app/ui/types/location";

const projection = ref('EPSG:3857')
const zoom = ref(16)
const markerIcon = '/images/marker.png';

export interface Props {
  center?: Location,
}

const props = withDefaults(defineProps<Props>(), {
  center: [3386118.8560390227, 6527692.993243565],
})
</script>

<template>
  <ClientOnly>
    <ol-map
      :loadTilesWhileAnimating="true"
      :loadTilesWhileInteracting="true"
      style="height:150px; cursor: pointer"
    >
      <ol-view
        :center="center"
        :zoom="zoom"
        :projection="projection"
      />
      <ol-tile-layer>
        <ol-source-osm />
      </ol-tile-layer>
      <ol-vector-layer
        :updateWhileAnimating="true"
        :updateWhileInteracting="true"
      >
        <ol-source-vector>
          <ol-feature>
            <ol-geom-point
              :coordinates="center"
            ></ol-geom-point>

            <ol-style>
              <ol-style-icon :src="markerIcon" :scale="0.1" :anchor="[0.5, 1]"></ol-style-icon>
            </ol-style>
          </ol-feature>
        </ol-source-vector>
      </ol-vector-layer>
    </ol-map>
  </ClientOnly>
</template>
