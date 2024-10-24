<template>
  <form @submit.prevent="submitForm">
    <div>
      <label for="name">Name:</label>
      <input v-model="user.name" id="name" type="text" required>
    </div>

    <div>
      <label for="email">Email:</label>
      <input v-model="user.email" id="email" type="email" required>
    </div>

    <div>
      <label for="tenants">Select Tenants:</label>
      <multiselect 
      v-model="user.tenants" 
      :options="tenantOptions" 
      placeholder="Select tenants" 
      label="name" 
      track-by="id"  
      multiple>
    </multiselect>
    </div>

    <div>
      <label for="password">Password:</label>
      <input v-model="user.password" id="password" type="password" required>
    </div>

    <div>
      <label for="password_confirmation">Confirm Password:</label>
      <input v-model="user.password_confirmation" id="password_confirmation" type="password" required>
    </div>

    <div v-if="Object.keys(errors).length">
      <ul>
        <li v-for="(error, index) in errors" :key="index">{{ error[0] }}</li>
      </ul>
    </div>

    <button type="submit">Create User</button>
  </form>
</template>

<script>
import Multiselect from 'vue-multiselect';
import axios from 'axios';

export default {
  components: { Multiselect },
  props: {
    tenants: Array,
  },
  data() {
    return {
      user: {
        name: '',
        email: '',
        password: '',
        password_confirmation: '',
        tenants: [],
      },
      tenantOptions: this.tenants,
      errors: {},
    };
  },
  methods: {
    submitForm() {
    axios.post('/users', this.user)
        .then(response => {
            alert('User created successfully');
            this.resetForm();
        })
        .catch(error => {
            if (error.response && error.response.status === 422) {
                this.errors = error.response.data.errors;
            }
        });
    },
    resetForm() {
      this.user = {
        name: '',
        email: '',
        password: '',
        password_confirmation: '',
        tenants: [],
      };
      this.errors = {};
    },
  }
}
</script>
