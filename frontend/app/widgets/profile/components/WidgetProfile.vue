<script setup lang="ts">

import NavigationButton from "~/app/widgets/profile/components/navigation/NavigationButton.vue";
import {defineProps} from "vue";
export interface Props {
  active?: string,
}

const props = withDefaults(defineProps<Props>(), {
  active: '',
})
</script>

<template>
  <ui-flex
    class="mt-5 mx-4"
    justify-content="between"
    style="min-height: 84vh"
  >
    <ui-flex :gap="2" class="px-6 mr-4" direction="column" style="width: 400px">
      <navigation-button
        label="Панель керування"
        icon="building-columns"
        :active="active === 'dashboard'"
        to="/profile"
      />
      <navigation-button
        label="Профіль"
        icon="user"
        :active="active === 'user'"
        to="/profile/user"
      />
      <navigation-button
        label="Покатушки"
        icon="calendar"
        :active="active === 'rides'"
        to="/profile/rides"
      />
      <navigation-button
        label="Маршрути"
        icon="map"
        :active="active === 'tracks'"
        to="/profile/tracks"
      />
      <navigation-button
        label="Повідомлення"
        icon="send"
        :active="active === 'messages'"
        to="/profile/messages"
      />
      <navigation-button
        label="Вийти"
        icon="sign-out"
        to="/"
      />
    </ui-flex>
    <ui-flex class="border-round-xs" :grow="1">
      <Card style="width: 100%">
        <template #title>
          <slot name="title" />
        </template>
        <template #content>
         <div>
           <slot name="content" />
         </div>
        </template>
      </Card>
    </ui-flex>
  </ui-flex>
</template>

<style scoped>

</style>