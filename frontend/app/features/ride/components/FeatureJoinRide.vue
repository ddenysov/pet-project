<script setup lang="ts">
import type {Ride} from "~/app/model/ride/types/ride";
import {useRideStore} from "~/app/model/ride/store/ride";

export interface Props {
  ride: Ride,
}

defineProps<Props>();

const rideStore = useRideStore();

async function joinRide(id: string) {
  rideStore.join(id)
}
</script>

<template>
  <Button
    v-if="!ride.joined" @click="joinRide(ride.id)"
    :label="ride.pending_join ? 'На розгляді' : 'Поїхали'"
    severity="danger"
    outlined
    class="w-full"
    :disabled="ride.pending_join"
  />
</template>

<style scoped>

</style>