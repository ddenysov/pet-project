<script setup lang="ts">
import type {Ride} from "~/app/model/ride/types/ride";
import {useRideStore} from "~/app/model/ride/store/ride";

export interface Props {
  ride: Ride,
}

defineProps<Props>();

const rideStore = useRideStore();
const isPending = ref(false);

async function joinRide(id: string) {
  // Сначала изменяем локальное состояние кнопки
  isPending.value = true;

  try {
    // Отправляем запрос к серверу
    await rideStore.join(id);
  } catch (e) {
    // Независимо от результата устанавливаем статус обратно в зависимости от ответа от сервера
    isPending.value = false;
  }
}
</script>

<template>
  <Button
    v-if="!ride.joined"
    @click="joinRide(ride.id)"
    :label="(isPending || ride.pending_join) ? 'На розгляді' : 'Поїхали'"
    severity="danger"
    outlined
    class="w-full"
    :disabled="(isPending || ride.pending_join)"
  />
</template>

<style scoped>

</style>