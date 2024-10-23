<template>
  <div>
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
    <ui-section style="padding: 0 5rem">
      <ui-flex direction="column">
        <ui-flex justify-content="center">
          <h1>Наступні покатушки</h1>
        </ui-flex>
        <ui-flex grow="1" gap="8">
          <ui-flex grow="1">
            <ui-card style="width: 100%; overflow: hidden">
              <template #header>
                <img style="width: 100%" alt="user header" src="/media/sample1.jpeg" />
              </template>
              <template #title>Advanced Card</template>
              <template #subtitle>Card subtitle</template>
              <template #footer>
                <div class="flex gap-4 mt-1">
                  <Button label="Cancel" severity="secondary" outlined class="w-full" />
                  <Button label="Save" class="w-full" />
                </div>
              </template>
            </ui-card>
          </ui-flex>

          <ui-flex grow="1">
            <ui-card style="width: 100%; overflow: hidden">
              <template #header>
                <img style="width: 100%" alt="user header" src="/media/sample1.jpeg" />
              </template>
              <template #title>Advanced Card</template>
              <template #subtitle>Card subtitle</template>
              <template #footer>
                <div class="flex gap-4 mt-1">
                  <Button label="Cancel" severity="secondary" outlined class="w-full" />
                  <Button label="Save" class="w-full" />
                </div>
              </template>
            </ui-card>
          </ui-flex>

          <ui-flex grow="1">
            <ui-card style="width: 100%; overflow: hidden">
              <template #header>
                <img style="width: 100%" alt="user header" src="/media/sample1.jpeg" />
              </template>
              <template #title>Advanced Card</template>
              <template #subtitle>Card subtitle</template>
              <template #footer>
                <div class="flex gap-4 mt-1">
                  <Button label="Cancel" severity="secondary" outlined class="w-full" />
                  <Button label="Save" class="w-full" />
                </div>
              </template>
            </ui-card>
          </ui-flex>


        </ui-flex>
      </ui-flex>

    </ui-section>
  </div>
</template>
<script setup lang="ts">
import UiSection from "~/app/ui/components/section/UiSection.vue";

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

definePageMeta({
  menu: 'main',
})
</script>

<style scoped>
.selected {
  background-color: var(--p-surface-100) !important;
  border-color: var(--p-surface-200) !important;
}
</style>