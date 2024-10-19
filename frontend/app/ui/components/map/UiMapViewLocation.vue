<script setup lang="ts">
const center = ref([3386118.8560320227, 6527692.993243565])
const projection = ref('EPSG:3857')
const zoom = ref(16)
const markerCenter = ref([3386118.8560320227, 6527692.993243565])
const markerIcon = '/images/marker.png';
</script>

<template>
  <ClientOnly>
    <ol-map
      :loadTilesWhileAnimating="true"
      :loadTilesWhileInteracting="true"
      style="height:500px; cursor: pointer"
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
              :coordinates="markerCenter"
            ></ol-geom-point>

            <ol-style>
              <ol-style-icon :src="markerIcon" :scale="0.1"></ol-style-icon>
            </ol-style>
          </ol-feature>
        </ol-source-vector>
      </ol-vector-layer>
    </ol-map>
  </ClientOnly>
</template>
