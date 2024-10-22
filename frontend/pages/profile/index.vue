<script setup lang="ts">

</script>

<template>
  <ui-flex
    class="mt-5 mx-4"
    justify-content="between"
    style="height: 84vh"
  >
    <ui-flex :gap="2" class="px-6 mr-4" direction="column" style="width: 500px">
      <ui-flex>
        <Button icon="pi pi-building-columns" style="justify-content: flex-start" class="w-full" label="Панель керування" severity="primary" />
      </ui-flex>
      <ui-flex>
        <Button icon="pi pi-user" style="justify-content: flex-start" class="w-full" label="Профіль" severity="secondary" text />
      </ui-flex>
      <ui-flex>
        <Button icon="pi pi-calendar" style="justify-content: flex-start" class="w-full" label="Покатушки" severity="secondary" text />
      </ui-flex>
      <ui-flex>
        <Button icon="pi pi-map" style="justify-content: flex-start" class="w-full" label="Маршрути" severity="secondary" text />
      </ui-flex>
      <ui-flex>
        <Button icon="pi pi-user" style="justify-content: flex-start" class="w-full" label="Повідомлення" severity="secondary" text />
      </ui-flex>
      <ui-flex>
        <Button icon="pi pi-sign-out" style="justify-content: flex-start" class="w-full" label="Вийти" severity="secondary" text />
      </ui-flex>
    </ui-flex>
    <ui-flex class="border-round-xs" :grow="1" style="background-color: white">
      <Card>
        <template #title>Панель керування</template>
        <template #content>
          <p class="m-0">
            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Inventore sed consequuntur error repudiandae numquam deserunt quisquam repellat libero asperiores earum nam nobis, culpa ratione quam perferendis esse, cupiditate neque
            quas!
          </p>
        </template>
      </Card>
    </ui-flex>
  </ui-flex>
</template>

<style scoped>

</style>