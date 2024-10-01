<script setup lang="ts">
import {useAuthStore} from "~/app/shared/auth/store/auth";

const formVisible = ref(false);
const dialog = ref(null);
const authStore = useAuthStore();

const onRegisterButtonClick = () => {
  dialog.value.show();
}

const onRegisterSuccess = () => {
  dialog.value.close();
}

</script>

<template>
  <div v-if="!authStore.isLoggedIn()">
    <ui-button
      label="Реєстрація"
      color="accent"
      @click="onRegisterButtonClick"
    />
    <ui-dialog ref="dialog">
      <ui-flex grow="1" direction="column">
        <ui-text-field
          form="sign-up"
          label="Електронна пошта"
          name="email"
          :validation="{ required: true, email: true }"
        />

        <ui-text-field
          form="sign-up"
          label="Пароль"
          name="password"
        />

        <ui-submit-button
          action="/api/iam/register"
          form="sign-up"
          label="Реєстрація"
          name="submit"
          @submit="onRegisterSuccess"
        />
      </ui-flex>
    </ui-dialog>
  </div>
</template>

<style scoped>

</style>