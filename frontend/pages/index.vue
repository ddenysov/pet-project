<template>
  <div>
    <h1>Welcome to the index page</h1>

    <Button label="Check" icon="pi pi-check" />

    <i class="pi pi-check"></i>
    <i class="pi pi-times"></i>
    <span class="pi pi-search"></span>
    <span class="pi pi-user"></span>

    <IconField>
      <InputIcon class="pi pi-search" />
      <InputText v-model="value1" placeholder="Search" />
    </IconField>

    <IconField>
      <InputText v-model="value2" />
      <InputIcon class="pi pi-spin pi-spinner" />
    </IconField>
  </div>
</template>
