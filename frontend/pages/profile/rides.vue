<script setup lang="ts">

import WidgetProfile from "~/app/widgets/profile/components/WidgetProfile.vue";
import WidgetMyRides from "~/app/widgets/ride/my-rides/components/WidgetMyRides.vue";
</script>

<template>
  <widget-profile active="rides">
    <template #title>
      Покатушки
    </template>
    <template #content>
      <div>
        Покатушки в розробці
        <ui-button
          class="ml-2"
          label="Додати катку"
          @click="() => navigateTo('/ride/create')"
        />

        <widget-my-rides />
      </div>
    </template>
  </widget-profile>
</template>
