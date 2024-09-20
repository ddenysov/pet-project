<template>
  <div>
    <h1>Create Ride</h1>

    <div>
    <ui-flex>
      <ui-flex grow="1">-</ui-flex>
      <ui-flex grow="1" direction="column">
        <ui-text-field
          form="create-ride"
          label="Назва покатушки"
          name="name"
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

        <ui-submit-button
          action="/api/ride/create-ride"
          form="create-ride"
          label="Створити покатушку"
          name="submit"
          @submit="submit"
        />
      </ui-flex>
      <ui-flex grow="1">-</ui-flex>
    </ui-flex>
    </div>
  </div>
</template>
<script setup lang="ts">
import {useMessageStore} from "~/components/ui/message/store";

const messageStore = useMessageStore();
async function submit(id: string) {
  messageStore.showMessage('layout', 'Покатушка буде створена незабаром.');
  await navigateTo('/ride');
}


</script>
