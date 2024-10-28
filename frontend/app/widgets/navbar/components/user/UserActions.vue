<script setup lang="ts">

</script>

<template>
  <div>
    <Button @click="togglePopover" style="width: 31px; height: 31px" outlined icon="pi pi-bell"
            aria-label="Save" />
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
  </div>
</template>

<style scoped>

</style>