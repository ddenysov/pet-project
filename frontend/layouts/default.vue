<script setup lang="ts">
import {useUserStore} from "~/stores/user";
import {useMessageStore} from "~/components/ui/message/store";
const store = useUserStore();
const items = ref([
  {
    label: 'Home',
    icon: 'pi pi-home'
  },
  {
    label: 'Features',
    icon: 'pi pi-star'
  },
  {
    label: 'Projects',
    icon: 'pi pi-search',
    items: [
      {
        label: 'Components',
        icon: 'pi pi-bolt'
      },
      {
        label: 'Blocks',
        icon: 'pi pi-server'
      },
      {
        label: 'UI Kit',
        icon: 'pi pi-pencil'
      },
      {
        label: 'Templates',
        icon: 'pi pi-palette',
        items: [
          {
            label: 'Apollo',
            icon: 'pi pi-palette'
          },
          {
            label: 'Ultima',
            icon: 'pi pi-palette'
          }
        ]
      }
    ]
  },
  {
    label: 'Contact',
    icon: 'pi pi-envelope'
  }
]);

const menu = ref();
const menuItems = ref([
  {
    label: 'Профіль',
    items: [
      {
        label: 'Вийти',
        icon: 'pi pi-sign-out',
        command: () => {
          store.logout()
        }
      }
    ]
  }
]);

const toggle = (event: any) => {
  menu.value.toggle(event);
};
</script>

<template>
  <div>
    <ui-toolbar>
      <template #start>
        Поїхавші
      </template>
      <template #center>
        <Menubar style="border: none" :model="items" />
      </template>
      <template #end>

        <Avatar @click="toggle" label="P" class="mr-2 cursor-pointer" size="large" shape="circle" />
        <Menu ref="menu" id="overlay_menu" :model="menuItems" :popup="true" />
        <ui-button class="ml-2" label="Створити покатушку" @click="() => navigateTo('/ride/create')" />
      </template>
    </ui-toolbar>
    <ui-message name="layout" />
    <ui-nav-link to="/" label="home" />
    <ui-nav-link v-if="!store.isLoggedIn()" to="/login" label="Увійти" />
    <ui-nav-link v-if="!store.isLoggedIn()" to="/register" label="Реєстрація" />
    <ui-nav-link v-if="store.isLoggedIn()" to="/ride/create" label="Створити поктушку" />
    <ui-nav-link to="/ride" label="Список покатушек" />
    <ui-link
      v-if="store.isLoggedIn()"
      to="/sign-in"
      label="Вийти"
      @click="store.logout()"
    />
    <slot />
  </div>
</template>

<style scoped>

</style>