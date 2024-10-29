<script setup lang="ts">
import {defineProps} from "vue";
import type {Location} from "~/app/ui/types/location";

const projection = ref('EPSG:3857')
const zoom = ref(16)
const markerIcon = '/images/marker.png';

export interface Props {
  center?: Location,
  height?: number,
  marker?: boolean,
}

const props = withDefaults(defineProps<Props>(), {
  center: [3386118.8560390227, 6527692.993243565],
  height: 300,
  marker: false,
})
const dialog = ref(null);
const previewClick = () => {
  dialog.value.show();
  console.log('OK');
}

</script>

<template>
  <ClientOnly>
    <ol-map
      :loadTilesWhileAnimating="true"
      :loadTilesWhileInteracting="true"
      :style="'height:' + height + 'px; cursor: pointer'"
      :controls="[]"
      :interactions="[]"
      @click="previewClick"
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
        v-if="marker"
        :updateWhileAnimating="true"
        :updateWhileInteracting="true"
      >
        <ol-source-vector>
          <ol-feature>
            <ol-geom-point
              :coordinates="center"
            />
            <ol-style>
              <ol-style-icon :src="markerIcon" :scale="0.1" :anchor="[0.5, 1]" />
            </ol-style>
          </ol-feature>
        </ol-source-vector>
      </ol-vector-layer>
    </ol-map>

    <ui-dialog title="Мапа" style="min-width: 90%" ref="dialog">
      <ol-map
        :loadTilesWhileAnimating="true"
        :loadTilesWhileInteracting="true"
        :style="'height:800px; cursor: pointer'"
        @click="previewClick"
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
          v-if="marker"
          :updateWhileAnimating="true"
          :updateWhileInteracting="true"
        >
          <ol-source-vector>
            <ol-feature>
              <ol-geom-point
                :coordinates="center"
              />
              <ol-style>
                <ol-style-icon :src="markerIcon" :scale="0.1" :anchor="[0.5, 1]" />
              </ol-style>
            </ol-feature>
          </ol-source-vector>
        </ol-vector-layer>
      </ol-map>
    </ui-dialog>
  </ClientOnly>
</template>
