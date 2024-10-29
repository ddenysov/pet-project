<script setup lang="ts">
import WidgetNavbar from "~/app/widgets/navbar/components/WidgetNavbar.vue";
import FeatureRegister from "~/app/features/register/components/FeatureRegister.vue";
import FeatureLogin from "~/app/features/login/components/FeatureLogin.vue";
import WidgetAvatar from "~/app/widgets/navbar/components/avatar/WidgetAvatar.vue";
import WidgetNavbarUserActions from "~/app/widgets/navbar/components/WidgetNavbarUserActions.vue";
import {useAuthStore} from "~/app/shared/auth/store/auth";

const route = useRoute()
const authStore = useAuthStore();
</script>

<template>
  <div>
    <widget-navbar
      :active="route.meta.menu"
      :logged="authStore.isLoggedIn()"
    >
      <template #guest>
        <feature-login />
        <div style="width: 16px"></div>
        <feature-register />
        <div style="width: 16px"></div>
      </template>
      <template #user>
        <widget-navbar-user-actions
          @logout="() => authStore.logout()"
        />
      </template>
    </widget-navbar>
    <ui-container style="padding: 2rem; background-color: var(--p-surface-100); width: 100%">
      <slot />
    </ui-container>
  </div>
</template>

<style scoped>

</style>