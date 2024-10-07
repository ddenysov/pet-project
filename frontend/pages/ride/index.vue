<template>
  <div>
    <Toast />
    <h1>Список покатушек</h1>

    <div>
      <ui-flex>
        <ui-flex grow="1" direction="column">
          <ui-data-grid
            name="rides"
            dataset="/api/ride/list-ride"
          >
            <template #default="{ item }">
              <ui-card style="margin: 10px">
                <template #header>
                  <div class="image-container">
                    <img :src="item.preview_image_url" />
                  </div>
                </template>
                <template #title>
                  <ui-router-link :label="item.name" :to="'/ride/view/' + item.id" />
                </template>
                <template #footer>
                  <div class="flex gap-3 mt-1">
                    <Button
                      v-if="!item.joined" @click="joinRide(item.id)"
                      :label="item.pending_join ? 'На розгляді' : 'Поїхали'"
                      severity="danger"
                      outlined
                      class="w-full"
                      :disabled="item.pending_join"
                    />
                    <Button @click="edit(item.id)" label="Редагувати" outlined class="w-full" />
                  </div>
                </template>
              </ui-card>
            </template>
          </ui-data-grid>
        </ui-flex>
      </ui-flex>
    </div>
  </div>
</template>
<script setup lang="ts">
import {useRideStore} from "~/app/model/ride/store/ride";
import {useDataStore} from "~/app/ui/store/data";
import {useToast} from 'primevue/usetoast';
import {useMessageStore} from "~/app/ui/store/messages";

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
const rideStore = useRideStore();
const dataStore = useDataStore();


async function edit(id: string) {
  await navigateTo('/ride/edit/' + id)
}

async function joinRide(id: string) {
  console.log('OK JOIN RIDE');
  const ride = dataStore.find('rides', id);
  rideStore.join(id)
  ride.pending_join = true;
}
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