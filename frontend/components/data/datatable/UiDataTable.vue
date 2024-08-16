<script setup lang="ts">
import { defineProps, ref, getCurrentInstance, h } from 'vue'
import Column from 'primevue/column'
import DataTable from 'primevue/datatable'
import { useClient } from '@/components/data/datatable/client'
import { onMounted } from 'vue';
const { fetchData } = useClient()
import type { Ref } from 'vue'

export interface Props {
  name: string,
}

defineProps<Props>()

const loading = ref(false)
const totalRecords = ref(100)
const first = ref(0)

const data: Ref<any> = ref([])

const loadData = async () => {
  loading.value = true
  data.value = await fetchData()
  loading.value = false
}

const onPage = async (event: any) => {
  console.log(event)
    await loadData();
}

onMounted(async () => {
  await loadData()
});

const instance: any = getCurrentInstance()
const render = () => {
  const renderSlot = (slot: any) => {
    return slot.children?.body ? {
      body: () => h(slot.children.body)
    } : {}
  }
  const childrenSlots = instance.slots.default()
  const children = childrenSlots.map((slot: any) => h(Column, {
    field: slot.props.name,
    header: slot.props.label
  }, renderSlot(slot)))

  return h(
    DataTable,
    {
      value: data.value,
      paginator: true,
      lazy: true,
      rows: 10,
      first: first.value,
      loading: loading.value,
      totalRecords: totalRecords.value,
      onPage
    },
    () => children
  )
}
</script>

<template>
  <render />
</template>
