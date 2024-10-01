<template>
  <div>
    <h1>Редагувати покатушку</h1>

    <div>
    <ui-flex>
      <ui-flex grow="1" direction="column">
        Деталі {{ route.params.id }}

        <pre>
          ID: {{ store.ride.id }}
          NAME: {{ store.ride.name }}
        </pre>
      </ui-flex>
    </ui-flex>

      <ui-flex>
        <ui-flex grow="1">-</ui-flex>
        <ui-flex grow="1" direction="column">
          <ui-text-field
            form="ride"
            label="Назва"
            name="name"
            :original="store.ride.name"
            :validation="{ required: true }"
          />

          <ui-submit-button
            :action="'/api/ride/update-ride/' + route.params.id"
            form="ride"
            label="Редагувати"
            name="submit"
          />
        </ui-flex>
        <ui-flex grow="1">-</ui-flex>
      </ui-flex>
    </div>
  </div>
</template>
<script setup lang="ts">
import {useRideStore} from "~/app/model/ride/store/ride";

const route = useRoute()
const store = useRideStore();

console.log('ok');
store.load(route.params.id);

// When accessing /posts/1, route.params.id will be 1
console.log(route.params.id)
</script>
