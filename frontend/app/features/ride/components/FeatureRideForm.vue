<script setup lang="ts">
async function submit(id: string) {
  await navigateTo('/ride');
}

</script>

<template>
  <ui-flex>
    <ui-flex grow="1" direction="column">
      <ui-text-field
        form="create-ride"
        label="Назва покатушки"
        name="name"
        :validation="{ required: true }"
      />

      <ui-text-area-field
        form="create-ride"
        label="Опис покатушки"
        name="description"
        :validation="{ required: true }"
      />

      <ui-grid>
        <ui-col col="6">
          <ui-select-field
            form="create-ride"
            label="Трек"
            name="track"
            :validation="{ required: true }"
          />
        </ui-col>
        <ui-col col="6">
          <ui-date-field
            form="create-ride"
            label="Дата"
            name="date"
            :validation="{ required: true }"
          />
        </ui-col>
      </ui-grid>

      <ui-grid>
        <ui-col col="6">
          <ui-time-field
            form="create-ride"
            label="час початку"
            name="time_start"
            :validation="{ required: true }"
          />
        </ui-col>
        <ui-col col="6">
          <ui-time-field
            form="create-ride"
            label="Час закінчення"
            name="time_end"
            :validation="{ required: true }"
          />
        </ui-col>
      </ui-grid>

      <ui-image-upload-field
        form="create-ride"
        label="Фото"
        name="image"
        :validation="{ required: true }"
      />

      <ui-grid>
        <ui-col col="6">
          <ui-location-field
            form="create-ride"
            label="Місце зустрічі"
            name="start_location"
          />
        </ui-col>
        <ui-col col="6">
          <ui-location-field
            form="create-ride"
            label="Місце фінфшу"
            name="finish_location"
          />
        </ui-col>
      </ui-grid>

      <ui-submit-button
        action="/api/ride/create-ride"
        form="create-ride"
        label="Створити покатушку"
        name="submit"
        @submit="submit"
      />
    </ui-flex>
  </ui-flex>
</template>

<style scoped>

</style>