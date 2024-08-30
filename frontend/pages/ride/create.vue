<template>
  <div>
    <h1>Create Ride</h1>

    <ui-flex>
      <ui-flex grow="1">-</ui-flex>
      <ui-flex grow="1" direction="column">
        <ui-text-field
          form="create-ride"
          label="Назва покатушки"
          name="name"
          :validation="{ required: true }"
        />

        <ui-submit-button
          action="/api/ride/create-ride"
          form="create-ride"
          label="Створити покатушку"
          name="submit"
        />
      </ui-flex>
      <ui-flex grow="1">-</ui-flex>
    </ui-flex>
  </div>
</template>
<script setup lang="ts">


</script>
