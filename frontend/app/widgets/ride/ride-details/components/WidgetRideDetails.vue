<script setup lang="ts">
import {useRideStore} from "~/app/model/ride/store/ride";
import SidebarSection from "~/app/widgets/ride/ride-details/components/ride-details/SidebarSection.vue";

const { ride } = useRideStore();
</script>

<template>
  <ui-flex gap="6" class="py-6">
    <ui-flex gap="4" direction="column" :grow="1" >
      <ui-flex class="bg-yellow-200 preview-image-container">
        <div class="container">
          <img :src="ride.image_url" alt="Image">
        </div>
      </ui-flex>
      <ui-flex><h1>{{ ride.name }}</h1></ui-flex>
      <ui-flex>{{ ride.description }}</ui-flex>
    </ui-flex>

    <ui-flex class="w-4">
      <ui-flex gap="4" direction="column" :grow="1">
        <ui-flex style="background-color: var(--p-surface-100);"  direction="column">
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

        <sidebar-section>
          <template #right>ICON</template>
          <template #first><ui-date-value :value="ride.start_date_time" /> </template>
          <template #second>
            <div>Початок: <ui-time-value :value="ride.start_date_time" />, кінець: <ui-time-value :value="ride.end_date_time" /></div>
          </template>
        </sidebar-section>

        <sidebar-section>
          <template #right>ICON</template>
          <template #first>Місце сбору: </template>
          <template #second>Заправка WOG на окружній</template>
          <template #bottom>
            <div style="height: 150px">
              <osm-map />
            </div>
          </template>
        </sidebar-section>

        <sidebar-section>
          <template #right>ICON</template>
          <template #first>Місце фінішу: </template>
          <template #second>метро Нивки</template>
          <template #bottom>
            <div style="height: 150px">
              <osm-map />
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

  .container {
    width: 100%; /* Укажите размеры блока */
    height: 100%; /* Укажите размеры блока */
    overflow: hidden; /* Обрезает изображение, выходящее за пределы */
    position: relative; /* Необходимо для позиционирования изображения */
  }

  .container img {
    width: 100%; /* Растягиваем изображение по ширине */
    height: 100%; /* Растягиваем изображение по высоте */
    object-fit: cover; /* Важное свойство: изображение обрежется по блокам */
    object-position: center; /* Центрирование изображения */
    display: block; /* Убираем лишние отступы */
  }

</style>