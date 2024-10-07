<template>
    <ui-section>
      <ui-breadcrumbs :items="items" :home="home" />
    </ui-section>

    <widget-ride-details />

    <ui-section>
      <div
        style="border-radius: 1rem; height: 400px; overflow: hidden; display: flex; justify-content: center; align-items: center">
        <Image style="object-fit: cover; object-position: center" :src="store.ride.image_url" alt="Image" width="100%"
               height="100%" />
      </div>
    </ui-section>

    <ui-section>
      <h1>{{ store.ride.name }}</h1>
    </ui-section>

    <ui-flex :gap="4">
      <ui-flex :grow="1">
        <div style="background-color: var(--p-surface-100); border-radius: 8px; padding: 1rem">
          <p>{{ store.ride.description }}</p>
        </div>
      </ui-flex>
      <ui-flex :gap="4" direction="column" class="w-4">
        <div style="background-color: var(--p-amber-100); border-radius: 8px; padding: 1rem">
          <div>Дата: <ui-date-value :value="store.ride.start_date_time" /></div>
          <div>Час початку: <ui-time-value :value="store.ride.start_date_time" /></div>
          <div>Час фінішу: <ui-time-value :value="store.ride.end_date_time" /></div>
          <div>Місце початку: Назва місця. <a href="#">Мапа</a></div>

        </div>
      </ui-flex>
    </ui-flex>
</template>
<script setup lang="ts">
import {useRideStore} from "~/app/model/ride/store/ride";
import UiBreadcrumbs from "~/app/ui/components/breadcrumbs/UiBreadcrumbs.vue";
import WidgetRideDetails from "~/app/widgets/ride/ride-details/components/WidgetRideDetails.vue";

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
</script>
