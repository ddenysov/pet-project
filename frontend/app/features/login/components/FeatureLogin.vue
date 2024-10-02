<script setup lang="ts">
import {useAuthStore} from "~/app/shared/auth/store/auth";

const dialog = ref(null);
const authStore = useAuthStore();

const onLoginButtonClick = () => {
  dialog.value.show();
}

const onLoginSuccess = async (res: any) => {
  authStore.setToken(res.res.token);
  dialog.value.close();
}

</script>

<template>
  <div v-if="!authStore.isLoggedIn()">
    <ui-button
      label="Увійти"
      color="primary"
      @click="onLoginButtonClick"
    />
    <ui-dialog ref="dialog">
      <ui-flex grow="1" direction="column">
        <ui-text-field
          form="login"
          label="Електронна пошта"
          name="email"
          :validation="{ required: true, email: true }"
        />

        <ui-text-field
          form="login"
          label="Пароль"
          name="password"
        />

        <ui-submit-button
          class="mt-2"
          action="/api/iam/login"
          form="login"
          label="Увійти"
          name="submit"
          @submit="onLoginSuccess"
        />
      </ui-flex>
    </ui-dialog>
  </div>
</template>

<style scoped>

</style>