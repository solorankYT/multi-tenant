<template>  
  <div>
    <h1>Tenants</h1>
    <button @click="createTenant">Create Tenant</button>
    <ul>
      <li v-for="tenant in tenants" :key="tenant.id">
        {{ tenant.name }} <!-- Display tenant name -->
        <button @click="editTenant(tenant.id)">Edit</button>
        <button @click="deleteTenant(tenant.id)">Delete</button>
      </li>
    </ul>
  </div>
</template>

<script setup>
import { Inertia } from '@inertiajs/inertia';
import { defineProps } from 'vue';

const props = defineProps({
  tenants: Array,
});

function createTenant() {
  Inertia.get('/tenants/create');
}

function editTenant(id) {
  Inertia.get(`/tenants/${id}/edit`);
}

function deleteTenant(id) {
  if (confirm('Are you sure you want to delete this tenant?')) {
    Inertia.delete(`/tenants/${id}`);
  }
}
</script>
