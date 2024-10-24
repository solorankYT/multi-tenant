<template>
  <div>
    <h1>{{ isEdit ? 'Edit Tenant' : 'Create Tenant' }}</h1>
    <form @submit.prevent="submit">
      <div>
        <label for="name">Tenant Name:</label>
        <input v-model="form.name" type="text" id="name" required>
      </div>
      <button type="submit">{{ isEdit ? 'Update Tenant' : 'Create Tenant' }}</button>
    </form>
  </div>
</template>

<script setup>
import { reactive } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import { defineProps } from 'vue';

const props = defineProps({
  tenant: Object,
  isEdit: Boolean,
});

const form = reactive({
  name: props.isEdit ? props.tenant.name : '',  // Prefill the name if editing
});

function submit() {
  if (props.isEdit) {
    Inertia.put(`/tenants/${props.tenant.id}`, form);
  } else {
    Inertia.post('/tenants', form);
  }
}
</script>
