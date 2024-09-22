<script setup lang="ts">
import {defineProps} from 'vue'
import {useFormStore} from './store/index';
import {Map, Layers, Sources} from "vue3-openlayers";
import { useTemplateRef, onMounted } from 'vue'

const store = useFormStore();

export interface Props {
  original?: string,
  disabled?: boolean,
  name: string,
  label: string,
  form: string,
  validation?: {},
}

const props = defineProps<Props>();

store.$patch({
  values: {
    [props.form]: {
      [props.name]: props.original,
    },
  },
  validation: {
    [props.form]: {
      [props.name]: props.validation,
    },
  },
  errors: {
    [props.form]: {
      [props.name]: '',
    },
  },
  loading: {
    [props.form]: false,
  },
});

watch(
  () => props.original,
  (newValue, oldValue) => {
    console.log(`Count changed from ${oldValue} to ${newValue}`);
    store.$patch({
      values: {
        [props.form]: {
          [props.name]: newValue,
        },
      },
    })
  }
);

function latLonToMercator(lat, lon) {
  const R = 6378137; // Радиус Земли в метрах (используемый для проекции Web Mercator)

  // Преобразуем долготу в радианы
  const x = R * lon * Math.PI / 180;

  // Преобразуем широту в радианы и используем формулу Меркатора
  const y = R * Math.log(Math.tan(Math.PI / 4 + lat * Math.PI / 360));

  return { x, y };
}

// Пример использования:
const kievCoords = { lat: 50.4501, lon: 30.5234 };
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

const markerIcon='/images/marker.png';

const drawEnable = ref(true);
const drawType = ref("Point");

const drawstart = (event) => {
  //console.log(event);
};

const drawend = (event) => {
  console.log(event.target.sketchCoords_);
  markerCenter.value = event.target.sketchCoords_;

  console.log('markerCenter.value');
  console.log(markerCenter.value);
};

</script>

<template>
  <ui-flex
    direction="column"
    :gap="2"
  >
    <label :for="name">{{ label }}</label>
    <ClientOnly>
      <ol-map :loadTilesWhileAnimating="true" :loadTilesWhileInteracting="true" style="height:400px">
        <ol-view :center="center" :rotation="rotation" :zoom="zoom"
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
    <small id="username-help">{{ store.getFieldError(form, name) }}</small>
  </ui-flex>
</template>

<style scoped>
.marker {
  background-color: #ffddaa;
  padding: 10px;
  border-radius: 25px;
  margin: 5px;
  font-size: 25px;
}
</style>