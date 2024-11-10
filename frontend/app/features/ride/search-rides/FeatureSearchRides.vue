<script setup lang="ts">

const members = ref([
  { name: 'Amy Elsner', image: 'amyelsner.png', email: 'amy@email.com', role: 'Owner' },
  { name: 'Bernardo Dominic', image: 'bernardodominic.png', email: 'bernardo@email.com', role: 'Editor' },
  { name: 'Ioni Bowcher', image: 'ionibowcher.png', email: 'ioni@email.com', role: 'Viewer' }
]);

const selected = ref('');

const op = ref();
const toggle = (event) => {
  op.value.toggle(event);
  selected.value = 'type';
}
</script>

<template>
  <ui-flex
    style="height: 200px"
    justify-content="center"
    align-items="center"
  >
    <ui-flex
      direction="column"
      style="background-color: var(--p-surface-100);"

    >
      <ui-flex style="border-radius: 1rem; background-color: white; padding: 1rem" gap="3">
        <Button @click="toggle" label="Тип велосипеда" text :class="{ selected: selected === 'type' }" />
        <Popover ref="op">
          <div class="flex flex-col gap-4">
            <div>
              <span class="font-medium block mb-2">Team Members</span>
              <ul class="list-none p-0 m-0 flex flex-col">
                <li v-for="member in members" :key="member.name" class="flex items-center gap-2 px-2 py-3 hover:bg-emphasis cursor-pointer rounded-border" @click="selectMember(member)">
                  <img :src="`https://primefaces.org/cdn/primevue/images/avatar/${member.image}`" style="width: 32px" />
                  <div>
                    <span class="font-medium">{{ member.name }}</span>
                    <div class="text-sm text-surface-500 dark:text-surface-400">{{ member.email }}</div>
                  </div>
                </li>
              </ul>
            </div>
          </div>
        </Popover>

        <Button label="Складність" text  />
        <Button label="Дистанція" text  />
        <Button icon="pi pi-search" aria-label="Save" />
      </ui-flex>
    </ui-flex>
  </ui-flex>
</template>

<style scoped>
.selected {
  background-color: var(--p-surface-100) !important;
  border-color: var(--p-surface-200) !important;
}
</style>