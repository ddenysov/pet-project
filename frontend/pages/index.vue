<template>
  <Layout>
    <ui-section
      style="height: 350px;"
    >
      <ui-flex
        direction="column"
        style="background-color: var(--p-surface-100); padding: 2rem"
      >
        <ui-flex gap="3">
          <ui-text-field
            form="search-ride"
            label="Тип велосипеду"
            name="name"
            :validation="{ required: true }"
          />

          <ui-text-field
            form="search-ride"
            label="Довжина маршруту"
            name="name"
            :validation="{ required: true }"
          />

          <ui-text-field
            form="search-ride"
            label="Складність"
            name="name"
            :validation="{ required: true }"
          />

          <ui-text-field
            form="search-ride"
            label="Локація"
            name="name"
            :validation="{ required: true }"
          />
        </ui-flex>
        <ui-flex justify-content="center" style="margin-top: 1rem">
          <ui-button label="Шукати"></ui-button>
        </ui-flex>

      </ui-flex>
    </ui-section>
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
  </Layout>
</template>
<script setup lang="ts">
import UiSection from "~/app/ui/components/section/UiSection.vue";

definePageMeta({
  menu: 'main',
})
</script>