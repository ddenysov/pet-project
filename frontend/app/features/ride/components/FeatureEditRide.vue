<script setup lang="ts">
import type {Ride} from "~/app/entity/ride/types/ride";
import {useRideStore} from "~/app/entity/ride/store/ride";

export interface Props {
  ride: Ride,
}

defineProps<Props>();

const rideStore = useRideStore();
async function edit(id: string) {
  await navigateTo('/ride/edit/' + id)
}
</script>

<template>
  <Button @click="edit(ride.id)" label="Редагувати" outlined class="w-full" />
</template>

<style scoped>

</style>