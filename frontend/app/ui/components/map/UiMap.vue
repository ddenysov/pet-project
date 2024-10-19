<template>
<div>
  <div class="mb-2">
    <ui-button color="accent" @click="clearDrawings" label="Зберегти" />
    <ui-button style="margin-left: 5px" @click="clearDrawings" label="Скасувати" />
    <ui-button style="margin-left: 5px" @click="clearDrawings" label="Очистити" />
    <ui-button style="margin-left: 5px" @click="undo" label="Відмінити останнє" />

    {{ calculateDistance(selected) }} км
  </div>


  <ol-map
    ref="mapRef"
    :loadTilesWhileAnimating="true"
    :loadTilesWhileInteracting="true"
    style="height: 82vh"
  >
    <ol-view
      ref="view"
      :center="center"
      :zoom="15"
      :projection="projection"
    />

    <ol-tile-layer>
      <ol-source-osm />
    </ol-tile-layer>

    <ol-vector-layer ref="vectorLayer">
      <ol-source-vector ref="sourceRef">
        <ol-interaction-draw
          type="Point"
          @drawend="drawend"
        />
      </ol-source-vector>
      <ol-style>
        <ol-style-fill color="rgba(255, 255, 255, 0.2)" />
        <ol-style-circle color="rgba(255, 255, 255, 0.2)" :radius="0">
          <ol-style-fill :color="stroke" />
        </ol-style-circle>
      </ol-style>
    </ol-vector-layer>

    <ol-vector-layer>
      <ol-source-vector ref="sourceRefRoute">
        <ol-feature>
          <ol-geom-line-string
            :coordinates="selected"
          ></ol-geom-line-string>
          <ol-style>
            <ol-style-stroke
              :color="stroke"
              :width="strokeWidth"
            ></ol-style-stroke>
          </ol-style>
        </ol-feature>
      </ol-source-vector>
    </ol-vector-layer>

    <ol-vector-layer>
      <ol-source-vector>
        <ol-feature>
          <ol-geom-circle :center="startPoint()" :radius="20"></ol-geom-circle>
          <ol-style>
            <ol-style-stroke color="red" :width="3"></ol-style-stroke>
            <ol-style-fill color="rgba(255,200,0,0.2)"></ol-style-fill>
          </ol-style>
        </ol-feature>
      </ol-source-vector>
    </ol-vector-layer>
  </ol-map>
</div>
</template>

<script setup lang="ts">
import {Map} from "ol";
import {LineString} from "ol/geom";
import {ref} from "vue";
import {getLength} from "ol/sphere";
import type VectorSource from "ol/source/vector";

const selected = ref([]);
const strokeWidth = ref(6);
const stroke = ref("#FF5500");
const sourceRef = ref<{ source: VectorSource }>(null);
const mapRef = ref<{ map: Map } | null>(null);
const vectorLayer = ref(null); // Ссылка на векторный слой
const center = ref([3386118.8560320227, 6527692.993243565])
const projection = ref('EPSG:3857')

const startPoint = () => {
  return selected.value.length > 0 ? selected.value[0] : [0,0];
}

const clearDrawings = () => {
  // Проверяем, что vectorSource инициализирован
  const source: any = sourceRef.value?.source;
  source.clear();
  selected.value = [];

};

function drawend(e: any) {
  const c = e.target.sketchCoords_;
  selected.value = [...selected.value, [c[0], c[1]]];
}

const undo = () => {
  selected.value.pop();
  selected.value = [...selected.value];
}

function calculateDistance(route) {
  const R = 6371; // Радиус Земли в километрах

  let totalDistance = 0;

  for (let i = 0; i < route.length - 1; i++) {
    const [x1, y1] = route[i];
    const [x2, y2] = route[i + 1];

    // Преобразуем координаты из меток проекции (EPSG:3857) в географические координаты (широта и долгота)
    const [lat1, lon1] = convertToLatLon(x1, y1);
    const [lat2, lon2] = convertToLatLon(x2, y2);

    const dLat = degreesToRadians(lat2 - lat1);
    const dLon = degreesToRadians(lon2 - lon1);

    const a =
      Math.sin(dLat / 2) * Math.sin(dLat / 2) +
      Math.cos(degreesToRadians(lat1)) *
      Math.cos(degreesToRadians(lat2)) *
      Math.sin(dLon / 2) *
      Math.sin(dLon / 2);

    const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));

    totalDistance += R * c;
  }

  return  Math.round(totalDistance * 10) / 10;
}

function degreesToRadians(degrees) {
  return (degrees * Math.PI) / 180;
}

function convertToLatLon(x, y) {
  // Константы для преобразования координат из проекции EPSG:3857 в географические (EPSG:4326)
  const originShift = 2 * Math.PI * 6378137 / 2.0;

  const lon = (x / originShift) * 180.0;
  const lat = (y / originShift) * 180.0;

  const latRad = (lat * Math.PI) / 180.0;
  const latFinal = (180.0 / Math.PI) * (2 * Math.atan(Math.exp(latRad)) - Math.PI / 2.0);

  return [latFinal, lon];
}

</script>

<style scoped>
/* Стили применяются только к текущему компоненту */

ol-map {
  height: 500px;
}
</style>