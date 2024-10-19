<script setup lang="ts">
import WidgetNavbar from "~/app/widgets/navbar/components/WidgetNavbar.vue";
import FeatureRegister from "~/app/features/register/components/FeatureRegister.vue";
import FeatureLogin from "~/app/features/login/components/FeatureLogin.vue";
import WidgetAvatar from "~/app/widgets/navbar/components/avatar/WidgetAvatar.vue";

</script>

<template>
  <div class="full-height-container">
    <slot />
  </div>
</template>

<style scoped>

</style>