<script setup lang="ts">
import {onMounted, useTemplateRef} from "vue";

function latLonToMercator(lat, lon) {
  const R = 6378137; // Радиус Земли в метрах (используемый для проекции Web Mercator)

  // Преобразуем долготу в радианы
  const x = R * lon * Math.PI / 180;

  // Преобразуем широту в радианы и используем формулу Меркатора
  const y = R * Math.log(Math.tan(Math.PI / 4 + lat * Math.PI / 360));

  return {x, y};
}

function mercatorToLatLon(x, y) {
  const R = 6378137; // Радиус Земли в метрах (используемый для проекции Web Mercator)

  // Преобразуем x в долготу
  const lon = x / R * 180 / Math.PI;

  // Преобразуем y в широту
  const lat = (Math.atan(Math.exp(y / R)) - Math.PI / 4) * 360 / Math.PI;

  return {lat, lon};
}

// Пример использования:
const kievCoords = {lat: 50.4501, lon: 30.5234};
const mercatorCoords = latLonToMercator(kievCoords.lat, kievCoords.lon);

const map = useTemplateRef('mapRef')

onMounted(() => {
  console.log(map.value);
})

const center = ref([3386118.8560320227, 6527692.993243565])
const projection = ref('EPSG:3857')
const zoom = ref(16)
const rotation = ref(0)

function centerChanged(a: any, b: any) {
  //markerCenter.value = a.target.getCenter();
}

const markerCenter = ref([3386118.8560320227, 6527692.993243565])

function click(e: any) {
  console.log(e);
}

const markerIcon = '/images/marker.png';

const drawEnable = ref(true);
const drawType = ref("Point");

const drawstart = (event) => {
  //console.log(event);
};

const $emit = defineEmits(['select'])

const drawend = async (event) => {
  markerCenter.value = event.target.sketchCoords_;
  await nextTick();
  $emit('select', event.target.sketchCoords_);
};

</script>

<template>
  <ClientOnly>
    <ol-map
      :loadTilesWhileAnimating="true"
      :loadTilesWhileInteracting="true"
      style="height:150px"
    >
      <ol-view
        :center="center"
        :rotation="rotation"
        :zoom="zoom"
        :projection="projection"
        @change:center="centerChanged"
      />
      <ol-tile-layer>
        <ol-source-osm />
      </ol-tile-layer>
      <ol-vector-layer
        :updateWhileAnimating="true"
        :updateWhileInteracting="true"
        title="STAR"
        preview="https://raw.githubusercontent.com/MelihAltintas/vue3-openlayers/main/src/assets/star.png"
      >
        <ol-source-vector ref="vectorsource">
          <ol-animation-shake>
            <ol-feature>
              <ol-geom-point
                :coordinates="markerCenter"
              ></ol-geom-point>

              <ol-style>
                <ol-style-icon :src="markerIcon" :scale="0.1"></ol-style-icon>
              </ol-style>
            </ol-feature>
          </ol-animation-shake>
          <ol-feature>
            <ol-geom-circle :center="markerCenter" :radius="2"></ol-geom-circle>
            <ol-style>
              <ol-style-stroke color="blue" :width="2"></ol-style-stroke>
              <ol-style-fill color="rgba(255,200,0,0.2)"></ol-style-fill>
            </ol-style>
          </ol-feature>
        </ol-source-vector>
      </ol-vector-layer>

      <ol-vector-layer>
        <ol-source-vector :projection="projection">
          <ol-interaction-draw
            v-if="drawEnable"
            :type="drawType"
            @drawend="drawend"
            @drawstart="drawstart"
          >
            <ol-style>
              <ol-style-stroke color="red" :width="2"></ol-style-stroke>
              <ol-style-fill color="rgba(255, 0, 0, 0.4)"></ol-style-fill>
              <ol-style-circle :radius="10">
                <ol-style-fill color="#CCCCCC" />
                <ol-style-stroke color="red" :width="2" />
              </ol-style-circle>
            </ol-style>
          </ol-interaction-draw>
        </ol-source-vector>

        <ol-style>
          <ol-style-stroke color="red" :width="2"></ol-style-stroke>
          <ol-style-fill color="rgba(255,255,255,0.1)"></ol-style-fill>
        </ol-style>
      </ol-vector-layer>
    </ol-map>
  </ClientOnly>
</template>
