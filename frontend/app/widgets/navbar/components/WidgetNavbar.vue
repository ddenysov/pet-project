<script setup lang="ts">
const items = reactive([
  {
    label: 'Головна',
    class: 'active',
    icon: 'pi pi-home',
    key: 'home',
    command: (e) => {
      items[0].class = 'active';
      items[1].class = '';
      items[2].class = '';
      items[3].class = '';
      navigateTo('/');
    },
  },
  {
    label: 'Покатушки',
    icon: 'pi pi-calendar',
    command: (e) => {
      items[0].class = '';
      items[1].class = 'active';
      items[2].class = '';
      items[3].class = '';
      navigateTo('/ride');
    },
  },
  {
    label: 'Маршрути',
    icon: 'pi pi-map',
    key: 'tracks',
    command: () => {
      items[0].class = '';
      items[1].class = '';
      items[2].class = 'active';
      items[3].class = '';
      navigateTo('/track');
    },
  },
  {
    label: 'О нас',
    icon: 'pi pi-envelope',
    key: 'about',
    command: () => {
      items[0].class = '';
      items[1].class = '';
      items[2].class = '';
      items[3].class = 'active';
      navigateTo('/about');
    },
  },
]);

const menu = ref();
const profileItems = ref([
  {
    items: [
      {
        label: 'Профіль',
        icon: 'pi pi-refresh',
        command: () => {
          items[0].class = '';
          items[1].class = '';
          items[2].class = 'active';
          items[3].class = '';
          navigateTo('/profile');
        },
      },
      {
        label: 'Вийти',
        icon: 'pi pi-upload'
      }
    ]
  }
]);

const toggle = (event) => {
  menu.value.toggle(event);
};
const op = ref();
const togglePopover = (event) => {
  op.value.toggle(event);
};



</script>

<template>
  <ui-flex
    align-items="center"
    justify-content="between"
    :gap="4"
  >
    <ui-flex :gap="2" align-items="center" class="py-3 px-5">
      <div style="background-color: var(--p-surface-700); height: 35px; width: 35px" />
      <div>Покатушки</div>
    </ui-flex>
    <ui-flex
      :grow="1"
      align-items="center"
      justify-content="between"
      class="px-5"
    >
      <ui-flex >
        <Menubar
          :model="items"
        />
      </ui-flex>
      <ui-flex :gap="2" align-items="center">
        <Button @click="togglePopover" style="width: 31px; height: 31px" outlined icon="pi pi-bell" aria-label="Save" />
        <Popover ref="op">
          <div class="flex flex-col gap-4">
            <div>
              <span class="font-medium block mb-2">Нових повідомлень енмає</span>
            </div>
          </div>
        </Popover>

        <Button @click="toggle" style="width: 31px; height: 31px" outlined icon="pi pi-cog" aria-label="Save" />
        <Menu ref="menu" id="overlay_menu" :model="profileItems" :popup="true" />
        <Divider layout="vertical" />
        <Avatar style="height: 35px; width: 35px" icon="pi pi-user" class="mr-2" size="small" shape="circle" />
        <div>Dmytro D.</div>
      </ui-flex>
    </ui-flex>
  </ui-flex>
</template>

<style scoped>
  .active {
    background-color: orangered;
  }
</style>