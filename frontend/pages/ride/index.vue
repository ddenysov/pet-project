<template>
  <div>
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
                  <Button v-if="!item.joined" @click="joinRide(item.id)" label="Поїхати" severity="danger" outlined class="w-full" />
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

const rideStore = useRideStore();
async function edit(id: string) {
  await navigateTo('/ride/edit/' + id)
}

async function joinRide(id: string) {
  console.log('OK JOIN RIDE');
  await rideStore.join(id)
}
</script>
