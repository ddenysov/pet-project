<template>
  <div>
    <ui-section align="center">
      <h1>Створити покатушку</h1>
      <feature-ride-form />
    </ui-section>
  </div>
</template>
<script setup lang="ts">
import {useMessageStore} from "~/app/ui/store/messages";
import FeatureRideForm from "~/app/features/ride/components/FeatureRideForm.vue";

const lock = ref(false);

const messageStore = useMessageStore();

</script>
