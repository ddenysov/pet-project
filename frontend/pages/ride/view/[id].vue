<template>
  <widget-ride-details />
</template>
<script setup lang="ts">
import {useRideStore} from "~/app/entity/ride/store/ride";
import WidgetRideDetails from "~/app/widgets/ride/ride-details/components/WidgetRideDetails.vue";
import {useAsyncData} from "#app";

const route = useRoute()
const store = useRideStore();

await useAsyncData('rideDetails', async () => {
  await store.load(route.params.id);

  return store.ride;
}, { lazy: true })



const home = ref({
  icon: 'pi pi-home',
  route: '/'
});
const items = ref([
  {label: 'Покатушки', route: '/ride'},
  {label: 'Деталі'},
]);

definePageMeta({
  menu: 'ride',
})
</script>
