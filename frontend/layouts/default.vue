<script setup lang="ts">
import WidgetNavbar from "~/app/widgets/navbar/components/WidgetNavbar.vue";
import FeatureRegister from "~/app/features/register/components/FeatureRegister.vue";
import FeatureLogin from "~/app/features/login/components/FeatureLogin.vue";
import WidgetAvatar from "~/app/widgets/navbar/components/avatar/WidgetAvatar.vue";

</script>

<template>
  <div>
    <widget-navbar>
      <template #actions>
        <feature-login />
        <div style="width: 16px"></div>
        <feature-register />
        <div style="width: 16px"></div>
        <widget-avatar />
      </template>
    </widget-navbar>
    <ui-container>
      <slot />
    </ui-container>
  </div>
</template>

<style scoped>

</style>