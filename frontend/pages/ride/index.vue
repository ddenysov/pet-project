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
              <ui-card>
                <template #title>
                  <ui-nav-link :label="item.name" :to="'/ride/view/' + item.id" />
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
import {useRideStore} from "~/stores/ride";
import {useDataStore} from "~/components/ui/data/store";
import {useToast} from 'primevue/usetoast';
import {useMessageStore} from "~/components/ui/message/store";

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
