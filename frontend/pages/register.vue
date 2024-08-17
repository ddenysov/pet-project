<template>
  <div>
    <h1>Welcome to the register page</h1>


    <ui-flex direction="column">
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
        form="sign-up"
        label="Реєстрація"
        name="submit"
      />
    </ui-flex>
  </div>
</template>
<script setup lang="ts">

</script>
