<script setup lang="ts">
import { defineProps } from 'vue'
import { useFormStore} from "~/app/ui/store/form";
import { useAuth } from "~/app/shared/api/composables/auth";

const store = useFormStore();

export interface Props {
  original?: string,
  disabled?: boolean,
  name: string,
  label: string,
  form: string,
  validation?: {},
}

const props = defineProps<Props>();

store.$patch({
  values: {
    [props.form]: {
      [props.name]: props.original,
    },
  },
  validation: {
    [props.form]: {
      [props.name]: props.validation,
    },
  },
  errors: {
    [props.form]: {
      [props.name]: '',
    },
  },
  loading: {
    [props.form]: false,
  },
});

watch(
  () => props.original,
  (newValue, oldValue) => {
    console.log(`Count changed from ${oldValue} to ${newValue}`);
    store.$patch({
      values: {
        [props.form]: {
          [props.name]: newValue,
        },
      },
    })
  }
);

const onUpload = (event) => {
  const { xhr, files } = event;
  const response = JSON.parse(xhr.response); // You can also directly check xhr.responseText
  console.log('Server Response:', response);
  console.log('Uploaded Files:', files);

  store.$patch({
    values: {
      [props.form]: {
        [props.name]: response.url,
      },
    },
  })
}

const onBeforeSend = (event) => {
  const { getHeader } = useAuth();
  const header = getHeader();
  event.xhr.setRequestHeader(header.key, header.value)
}

</script>

<template>
  <ui-flex
    direction="column"
    :gap="2"
  >
    <label :for="name">{{ label }}</label>

    <FileUpload
      name="demo"
      url="/api/track/upload"
      :multiple="false"
      accept=".gpx"
      :show-cancel-button="false"
      :show-upload-button="false"
      auto
      :maxFileSize="10000000"
      :file-limit="1"
      @upload="onUpload"
      @before-send="onBeforeSend"
    >
      <template #empty>
        <span>Drag and drop files to here to upload GPX file.</span>
      </template>
    </FileUpload>

    <small id="username-help">{{ store.getFieldError(form, name) }}</small>
  </ui-flex>
</template>
