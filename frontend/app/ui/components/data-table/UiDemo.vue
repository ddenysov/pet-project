<script lang="ts">
import { ref, h } from 'vue'
import DataTable from 'primevue/datatable'
import Column from 'primevue/column'


export default {
  props: {
    /* ... */
  },
  setup(props, { slots }: { slots: any }) {
    const data = ref([
      {
        id: 1,
        name: 'ololo',
      },
      {
        id: 2,
        name: 'ololo1',
      },
      {
        id: 3,
        name: 'ololo2',
      },
      {
        id: 4,
        name: 'ololo3',
      },
      {
        id: 5,
        name: 'ololo4',
      },
    ]);

    const childrenSlots = slots.default();
    const children = childrenSlots.map((slot: any) => h(Column, {
      field: slot.props.name,
      header: slot.props.label
    }, {
      body: () => h(slot.children.body)
    }))

    return () => h(
      DataTable,
      {
        value: data.value,
      },
      () => children,
    )
  }
}
</script>