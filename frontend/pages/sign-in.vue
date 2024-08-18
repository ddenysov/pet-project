<template>
  <div>
    <div v-if="isLoggedIn()">
      Ви увійшли в систему: {{ store.email }}
    </div>
    <div v-if="showCheckEmail()">
      <h1>Увійдіть або зареєструйтесь</h1>
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


    <div v-if="showLogin()">
      <h1>Увійдіть до свого акаунту</h1>
      <ui-flex>
        <ui-flex grow="1">-</ui-flex>
        <ui-flex grow="1" direction="column">
          <ui-text-field
            form="sign-in"
            :original="store.email"
            label="Електронна пошта"
            name="email"
            :validation="{ required: true, email: true }"
            :disabled="true"
          />
          <ui-text-field
            form="sign-in"
            label="Пароль"
            name="password"
          />
          <ui-submit-button
            action="/iam/login"
            form="sign-in"
            label="Увійти"
            name="submit"
            @submit="onLoginSuccess"
          />
        </ui-flex>
        <ui-flex grow="1">-</ui-flex>
      </ui-flex>
    </div>

    <div v-if="showRegister()">
      <h1>Створить новий аккаунт</h1>
      <ui-flex>
        <ui-flex grow="1">-</ui-flex>
        <ui-flex grow="1" direction="column">
          <ui-text-field
            :original="store.email"
            form="sign-up"
            label="Електронна пошта"
            name="email"
            :validation="{ required: true, email: true }"
            :disabled="true"
          />
          <ui-text-field
            form="sign-up"
            label="Пароль"
            name="password"
          />
          <ui-submit-button
            action="/iam/register"
            form="sign-up"
            label="Увійти"
            name="submit"
          />
        </ui-flex>
        <ui-flex grow="1">-</ui-flex>
      </ui-flex>
    </div>
  </div>
</template>
<script setup lang="ts">

import {useUserStore} from "~/stores/user";
const session = useCookie<{ name: string }>('session')


const store = useUserStore();

const showCheckEmail = () => {
  return !store.emailExists && !store.emailChecked && !store.token;
}

const showLogin = () => {
  return store.emailExists && store.emailChecked && !store.token;
}

const showRegister = () => {
  return !store.emailExists && store.emailChecked && !store.token;
}

const isLoggedIn = () => {
  return store.token;
}

const onRegisterSuccess = (data: any) => {
  console.log('res');
  console.log(data.res.exists);
  console.log(data.values);
  store.checkEmail(data.res.exists);
  store.setEmail(data.values.email);
}

const onLoginSuccess = (data: any) => {
  console.log('res');
  console.log(data.res.exists);
  console.log(data.values);
  store.setToken(data.res.token);
  session.value = { name: JSON.stringify({
      token: data.res.token,
      email: data.values.email
    }) };
}

</script>
