<template>
  <div>
    <ui-section
      style="height: 400px;background-color:  var(--p-surface-100)"
    >
      <ui-flex
        style="background-color: var(--p-surface-200); padding: 2rem;"
        direction="column"
      >
        <ui-flex gap="3">
          <ui-text-field
            form="search-ride"
            label="Тип велосипеду"
            name="name"
            :validation="{ required: true }"
          />

          <ui-text-field
            form="search-ride"
            label="Довжина маршруту"
            name="name"
            :validation="{ required: true }"
          />

          <ui-text-field
            form="search-ride"
            label="Складність"
            name="name"
            :validation="{ required: true }"
          />

          <ui-text-field
            form="search-ride"
            label="Локація"
            name="name"
            :validation="{ required: true }"
          />
        </ui-flex>
        <ui-flex justify-content="center" style="margin-top: 1rem">
          <ui-button label="Шукати"></ui-button>
        </ui-flex>

      </ui-flex>
    </ui-section>
    <ui-section
      style="height: 400px;background-color:  var(--p-surface-100); margin-top: 1px"
    >
      another section
    </ui-section>
  </div>
</template>
<script setup lang="ts">
import UiSection from "~/app/ui/components/section/UiSection.vue";
</script>