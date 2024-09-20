<script setup lang="ts">
import {useMessageStore} from "~/components/ui/message/store";

export interface Props {
  name: string,
}
const props = defineProps<Props>()
const store = useMessageStore();
</script>

<template>
  <Message
    v-if="store.getMessage(props.name)"
    severity="success"
    closable
    @close="store.clearMessage()"
  >
    {{ store.getMessage(props.name) }}
  </Message>
</template>

<style scoped>

</style>