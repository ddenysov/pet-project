<script setup lang="ts">
async function submit(id: string) {
  await navigateTo('/ride');
}

</script>

<template>
  <ui-flex class="w-5">
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

      <ui-date-field
        form="create-ride"
        label="Дата"
        name="date"
        :validation="{ required: true }"
      />

      <ui-time-field
        form="create-ride"
        label="час початку"
        name="time_start"
        :validation="{ required: true }"
      />

      <ui-time-field
        form="create-ride"
        label="Час закінчення"
        name="time_end"
        :validation="{ required: true }"
      />

      <ui-image-upload-field
        form="create-ride"
        label="Фото"
        name="image"
        :validation="{ required: true }"
      />

      <ui-location-field
        form="create-ride"
        label="Місце зустрічі"
        name="start_location"
      />

      <ui-location-field
        form="create-ride"
        label="Місце фінфшу"
        name="finish_location"
      />

      <ToggleButton v-model="lock" onLabel="Закрита" offLabel="Відкрита" onIcon="pi pi-lock"
                    offIcon="pi pi-lock-open" class="w-36 mb-2" aria-label="Do you confirm" />

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