<script setup lang="ts">

const dialog = ref(null);

const onUploadButtonClick = () => {
  dialog.value.show();
}

</script>

<template>
  <ui-button
    class="ml-2"
    label="Завантажити GPX"
    @click="() => onUploadButtonClick()"
  />
  <ui-dialog title="Завантажити GPX"  style="min-width: 500px" ref="dialog">
    <ui-flex grow="1" direction="column">
      <ui-image-upload-field />
    </ui-flex>
  </ui-dialog>
</template>

<style scoped>

</style>