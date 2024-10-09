<script setup lang="ts">
import {useRideStore} from "~/app/model/ride/store/ride";
import SidebarSection from "~/app/widgets/ride/ride-details/components/ride-details/SidebarSection.vue";

const { ride } = useRideStore();
</script>

<template>
  <ui-flex gap="6" class="bg-blue-200 p-6">
    <ui-flex gap="4" direction="column" :grow="1" class="bg-red-200">
      <ui-flex class="bg-yellow-200 preview-image-container">
        IMAAAAGE
      </ui-flex>
      <ui-flex  class="bg-cyan-700">Title</ui-flex>
      <ui-flex  class="bg-cyan-700">Description</ui-flex>
    </ui-flex>

    <ui-flex class="w-4">
      <ui-flex gap="4" direction="column" :grow="1">
        <ui-flex direction="column" class="bg-white">
          <ui-flex gap="2" class="p-3">
            <ui-flex>
              <ui-avatar image="/media/sample_avatar.jpg" />
            </ui-flex>
            <ui-flex justify-content="between" direction="column" :grow="1">
              <ui-flex class="p-1">Організатор покатушки:</ui-flex>
              <ui-flex class="p-1 font-bold">Dima D.</ui-flex>
            </ui-flex>
          </ui-flex>
        </ui-flex>

        <ui-flex direction="column" class="bg-white">
          <ui-flex gap="2" class="p-3">
            <ui-flex>
              <ui-avatar image="/media/sample_avatar.jpg" />
            </ui-flex>
            <ui-flex justify-content="between" direction="column" :grow="1">
              <ui-flex class="p-1">
                <ui-date-value :value="ride.start_date_time" />
              </ui-flex>
              <ui-flex class="p-1 ">
                Початок: <ui-time-value :value="ride.start_date_time" />, кінець: <ui-time-value :value="ride.end_date_time" />
              </ui-flex>
            </ui-flex>
          </ui-flex>
        </ui-flex>
        <ui-flex direction="column" class="bg-white">
          <ui-flex gap="2" class="p-3">
            <ui-flex>
              <ui-avatar image="/media/sample_avatar.jpg" />
            </ui-flex>
            <ui-flex justify-content="between" direction="column" :grow="1">
              <ui-flex class="p-1">Стартова локація:</ui-flex>
              <ui-flex class="p-1">Біля заправки WOG на окружній</ui-flex>
            </ui-flex>
          </ui-flex>
          <div class="bg-gray-600 h-10rem">Map</div>
        </ui-flex>

        <sidebar-section>
          <template #right>ICON</template>
          <template #first>Місце сбору: </template>
          <template #second>Заправка WOG на окружній</template>
          <template #bottom>
            <div style="height: 150px">
              Map
            </div>
          </template>
        </sidebar-section>

      </ui-flex>
    </ui-flex>
  </ui-flex>
</template>

<style scoped>
  .preview-image-container {
    height: 400px;
  }

</style>