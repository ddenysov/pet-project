<template>
  <ui-container>
    <ui-section>
      <ui-breadcrumbs :items="items" :home="home" />
    </ui-section>
    <ui-section>
      <div style="border-radius: 1rem; height: 400px; overflow: hidden; display: flex; justify-content: center; align-items: center">
        <Image style="object-fit: cover; object-position: center" src="/media/sample1.jpeg" alt="Image" width="100%" height="100%" />
      </div>
    </ui-section>

    <ui-section>
      <h1>{{ store.ride.name }}</h1>
    </ui-section>

    <ui-section>
      <p>{{ store.ride.description }}</p>
    </ui-section>
  </ui-container>
</template>
<script setup lang="ts">
import {useRideStore} from "~/app/model/ride/store/ride";
import UiBreadcrumbs from "~/app/ui/components/breadcrumbs/UiBreadcrumbs.vue";
const route = useRoute()
const store = useRideStore();

store.load(route.params.id);

const home = ref({
  icon: 'pi pi-home',
  route: '/'
});
const items = ref([
  { label: 'Покатушки', route: '/ride' },
  { label: 'Деталі' },
]);
</script>
