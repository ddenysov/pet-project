<template>
  <div>
    <h1>Список покатушек</h1>
    <widget-public-rides />
  </div>
</template>
<script setup lang="ts">
import {useToast} from 'primevue/usetoast';
import {useMessageStore} from "~/app/ui/store/messages";
import ModelRideCard from "~/app/entity/ride/components/ModelRideCard.vue";
import FeatureJoinRide from "~/app/features/ride/components/FeatureJoinRide.vue";
import FeatureEditRide from "~/app/features/ride/components/FeatureEditRide.vue";
import WidgetPublicRides from "~/app/widgets/ride/public-rides/components/WidgetPublicRides.vue";

const messageStore = useMessageStore();
const toast = useToast();
const show = (text: string) => {
  toast.add({severity: 'success', summary: 'Info', detail: text, life: 3000});
};
// ride.domain.event.rider_request_accepted_join_to_ride
const {$listen, $clear} = useNuxtApp()
$clear('ride.domain.event.rider_request_accepted_join_to_ride')
$clear('ride.domain.event.ride_created')
$listen('ride.domain.event.rider_request_accepted_join_to_ride', e => {
    show('Запит на участь в покатушці схвалено')
  }
)
$listen('ride.domain.event.ride_created', e => {
  show('Покатушка створена')
})

definePageMeta({
  menu: 'ride',
})
</script>

<style>
.image-container {
  width: 100%; /* Можно задать любую нужную ширину */
  height: 200px; /* Можно задать любую нужную высоту */
  overflow: hidden; /* Обрезать все, что выходит за пределы контейнера */
  position: relative;
}

.image-container img {
  width: 100%;
  height: 100%;
  object-fit: cover; /* Увеличить пропорционально и обрезать по краям */
  object-position: center; /* Разместить изображение по центру */
}
</style>