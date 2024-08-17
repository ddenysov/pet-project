<template>
  <div>
    <h1>Welcome to the register page</h1>

    <ui-flex>
      <ui-flex grow="1">-</ui-flex>
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
          action="/iam/register"
          form="sign-up"
          label="Реєстрація"
          name="submit"
          @submit="onRegisterSuccess"
        />
      </ui-flex>
      <ui-flex grow="1">-</ui-flex>
    </ui-flex>
  </div>
</template>
<script setup lang="ts">

import {useUserStore} from "~/stores/user";

const store = useUserStore();

console.log(store.setToken('as'));

//store.setToken('ololo');

const onRegisterSuccess = (res: any) => {
  console.log('res');
  console.log(res);
}

</script>
