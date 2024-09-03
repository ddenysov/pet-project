<template>
  <div>
    <h1>Увійдіть в систему</h1>

    <ui-flex>
      <ui-flex grow="1">-</ui-flex>
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
          action="/api/iam/login"
          form="login"
          label="Увійти"
          name="submit"
          @submit="onLoginSuccess"
        />
      </ui-flex>
      <ui-flex grow="1">-</ui-flex>
    </ui-flex>
  </div>
</template>
<script setup lang="ts">
import {useUserStore} from "~/stores/user";

const store = useUserStore();
const onLoginSuccess = async (res: any) => {
  console.log('res');
  console.log(res.res.token);
  store.setToken(res.res.token);
  await navigateTo('/')
}
</script>