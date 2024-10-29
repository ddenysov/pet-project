<script setup lang="ts">
const op = ref();
const togglePopover = (event) => {
  op.value.toggle(event);
};
const toggle = (event) => {
  menu.value.toggle(event);
};
const $emit = defineEmits(['logout'])
const menu = ref();
const profileItems = ref([
  {
    items: [
      {
        label: 'Профіль',
        icon: 'pi pi-refresh',
        command: () => {
          navigateTo('/profile');
        },
      },
      {
        label: 'Вийти',
        icon: 'pi pi-upload',
        command: () => {
          $emit('logout')
        },
      }
    ]
  }
]);
</script>

<template>
  <Button @click="togglePopover" style="width: 31px; height: 31px" outlined icon="pi pi-bell" aria-label="Save" />
  <Popover ref="op">
    <div class="flex flex-col gap-4">
      <div>
        <span class="font-medium block mb-2">Нові повідомлення відсутні</span>
      </div>
    </div>
  </Popover>
  <Button @click="toggle" style="width: 31px; height: 31px" outlined icon="pi pi-cog" aria-label="Save" />
  <Menu ref="menu" id="overlay_menu" :model="profileItems" :popup="true" />
  <Divider layout="vertical" />
  <Avatar style="height: 35px; width: 35px" icon="pi pi-user" class="mr-2" size="small" shape="circle" />
  <div>Dmytro D.</div>
</template>

<style scoped>

</style>