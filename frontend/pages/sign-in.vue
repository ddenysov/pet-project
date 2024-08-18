<template>
  <div>
    <h1>Welcome to the register page</h1>

    <ui-flex>
      <ui-flex grow="1">-</ui-flex>
      <ui-flex grow="1" direction="column">
        <ui-text-field
          form="sign-in"
          label="Електронна пошта"
          name="email"
          :validation="{ required: true, email: true }"
        />
        <ui-submit-button
          action="/iam/check-email"
          form="sign-in"
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

const onRegisterSuccess = (res: any) => {
  console.log('res');
  console.log(res);
}

</script>
