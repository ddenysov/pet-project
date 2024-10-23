<template>
  <widget-ride-details />
</template>
<script setup lang="ts">
import {useRideStore} from "~/app/model/ride/store/ride";
import UiBreadcrumbs from "~/app/ui/components/breadcrumbs/UiBreadcrumbs.vue";
import WidgetRideDetails from "~/app/widgets/ride/ride-details/components/WidgetRideDetails.vue";
import FeatureRideForm from "~/app/features/ride/components/FeatureRideForm.vue";

const route = useRoute()
const store = useRideStore();

store.load(route.params.id);

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
