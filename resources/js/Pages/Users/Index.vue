<template>
    <div>
      <h1>Users</h1>
      <ul>
        <li v-for="user in users" :key="user.id">
          {{ user.name }} ({{ user.email }})
          <button @click="editUser(user.id)">Edit</button>
          <button @click="deleteUser(user.id)">Delete</button>
        </li>
      </ul>
    </div>
  </template>
  
  <script setup>
  import { defineProps } from 'vue';
  import { Inertia } from '@inertiajs/inertia';
  
  const props = defineProps({
    users: Array,
  });
  
  function editUser(id) {
    Inertia.get(`/users/${id}/edit`);
  }
  
  function deleteUser(id) {
    if (confirm('Are you sure you want to delete this user?')) {
      Inertia.delete(`/users/${id}`);
    }
  }
  </script>
  