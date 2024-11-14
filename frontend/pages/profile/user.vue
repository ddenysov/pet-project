<script setup lang="ts">

import WidgetProfile from "~/app/widgets/profile/components/WidgetProfile.vue";

// avatar
// name
// опис
// save

// email
// password
// update password

</script>

<template>
  <widget-profile active="user">
    <template #title>
      Профіль
    </template>
    <template #content>
      <ui-flex justify-content="center">
        <ui-avatar style="width: 100px; height: 100px" image="/media/me.jpeg" />
      </ui-flex>
      <ui-flex grow="1" direction="column">
        <ui-text-field
          form="profile"
          label="Імя / нікнейм"
          name="name"
          :validation="{ required: true, email: true }"
        />

        <ui-text-area-field
          form="profile"
          label="Про мене"
          name="bio"
        />

        <ui-flex>
          <ui-submit-button
            style="margin-top: 10px"
            action="/api/iam/register"
            form="profile"
            label="Зберегти"
            name="submit"
          />
        </ui-flex>
      </ui-flex>

      <ui-flex style="margin-top: 40px" grow="1" direction="column">
        <ui-text-field
          form="sign-up"
          label="Пошта"
          name="email"
          original="test.user@gmail.com"
          :disabled="true"

          :validation="{ required: true, email: true }"
        />

        <ui-text-field
          form="sign-up"
          label="Пароль"
          name="password"
          :validation="{ required: true, email: true }"
        />

        <ui-flex>
          <ui-submit-button
            style="margin-top: 10px"
            action="/api/iam/register"
            form="profile"
            label="Змінити пароль"
            name="submit"
          />
        </ui-flex>
      </ui-flex>
    </template>
  </widget-profile>
</template>

<style scoped>

</style>